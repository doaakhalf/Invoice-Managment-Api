<?php

namespace App\Http\Controllers;

use App\Casts\ContractStatus;
use App\DTOs\CreateInvoiceDTO;
use App\DTOs\RecordPaymentDTO;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\ContractSummaryResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{

    public function __construct(
        private InvoiceService $invoiceService,
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Contract $contract,Request $request)
    {
       
       
        $invoices=$this->invoiceService->getByContractId($contract->id);
        return InvoiceResource::collection($invoices)->toArray($request);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request,Contract $contract)
    {
        
        $this->authorize('create',[Invoice::class, $contract]);
        if(!$contract){
            return response()->json([
                'message'=>'Invoice not created | contract not found',
            ],404);
        }
      
        if($contract->status !== ContractStatus::Active){
            return response()->json([
                'message'=>'Invoice not created | contract is not active',
            ],400);
        }
        try{
            $dto=CreateInvoiceDTO::formRequest($request,$contract);
            $InvoiceData=$this->invoiceService->createInvoice($dto,$contract);
            if(!$InvoiceData){
                return response()->json([
                    'message'=>'Invoice not created',
                ],400);
            }

            return InvoiceResource::make($InvoiceData)->response()->setStatusCode(201);
        }
        catch(\Exception $e){
            return response()->json([
                'message'=>'Invoice not created',
            ],400);
        }
     
    }

    /**
     * Display the specified resource.
     */
    public function show($invoice_id)
    {
        $invoice=$this->invoiceService->findById($invoice_id);
        $this->authorize('view',$invoice);
        if(!$invoice){
            return response()->json([
                'message'=>'Invoice not found',
            ],404);
        }
       
        return InvoiceResource::make($invoice)->response()->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function RecordPayment(Invoice $invoice,StorePaymentRequest $request)
    {
       
        $this->authorize('recordPayment',$invoice);
        if(!$invoice){
            return response()->json([
                'message'=>'Invoice not found',
            ],404);
        }
      
        $dto=RecordPaymentDTO::formRequest($request,$invoice);
        try{
            $payment=$this->invoiceService->RecordPayment($dto);
            return PaymentResource::make($payment)->response()->setStatusCode(201);
        }
        catch(\Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ],400);
        }
       
        
    }
    public function getContractSummary(Contract $contract)
    {
        
        $this->authorize('getContractSummary',[Invoice::class,$contract]);
        if(!$contract){
            return response()->json([
                'message'=>'Contract not found',
            ],404);
        }
        try {

            $contractSummary=$this->invoiceService->getContractSummary($contract->id);
            return ContractSummaryResource::make((object)$contractSummary)->response()->setStatusCode(200);

        } catch (\Throwable $th) {
            return response()->json([
                'message'=>'Error getting Contract summary ',
            ],400);
        }
      
    }
}
