<?php
namespace App\Services;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\RecordPaymentDTO;
use App\Interfaces\ContractRepositoryInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Tax\TaxService;
use App\Tax\TaxTypes\MunicipalFee;
use App\Tax\TaxTypes\VAT;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PaymentRepositoryInterface ;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class InvoiceService {
   
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private PaymentRepositoryInterface $paymentRepo,
        private TaxService $taxService,
    ) {
    }
    public  function createInvoice(CreateInvoiceDTO $dto,Contract $contract): Invoice { 

             $calculatedValues=[];
            //invoice_number','subtotal','tax_amount','total','status','due_date','paid_at','contract_id'
            $invoicenumber = $this->generateInvoiceNumber($contract->tenant_id);
            $calculatedValues['invoice_number']=$invoicenumber;


            if(env('TAX_TYPE')=='MunicipalFee'){
                $this->taxService->setTaxCalculator(new MunicipalFee);
            }
            else{
                  $this->taxService->setTaxCalculator(new VAT);
            }
       

            $subtotal=$contract->rent_amount;
            $tax_amount=number_format($this->taxService->calculate($subtotal), 2, '.', '');
            $total=number_format($subtotal+$tax_amount, 2, '.', '');
            $calculatedValues['total']=$total;
            $calculatedValues['tax_amount']=$tax_amount;
            $calculatedValues['paid_at']=date('Y-m-d');
            $calculatedValues['subtotal']=$subtotal;

           try{
                DB::beginTransaction();
                $invoice=$this->invoiceRepo->create((array)$dto+$calculatedValues);
                DB::commit();
                $remainingBalance=number_format($this->invoiceRepo->getRemainingBalance($invoice->id), 2, '.', '');
                $invoice->remaining_balance=$remainingBalance;
                return $invoice;
           }catch(\Exception $e){
                DB::rollBack();
                throw $e;
            
            }
        
     }


    public function recordPayment(RecordPaymentDTO $dto): Payment { 
      
        $invoice=$this->invoiceRepo->findById($dto->invoice_id);
   
        if ($invoice->contract->status !== 'active') {
            throw new \Exception('contract not active');
        }

        if($dto->amount>$this->invoiceRepo->getRemainingBalance($dto->invoice_id)){
            throw new \Exception('Payment amount is greater than remaining balance');
        }

        $invoicePaidAmount=$this->invoiceRepo->getpaidAmount($dto->invoice_id);
        $invoiceRemainingBalance=$this->invoiceRepo->getTotal($dto->invoice_id)-$invoicePaidAmount;
        if($dto->amount>$invoiceRemainingBalance){
            throw new \Exception('Payment amount is greater than remaining balance');
        }
        try {
            DB::beginTransaction();
            
            $payment=$this->paymentRepo->create((array)$dto+['paid_at'=>date('Y-m-d')]);
            $invoicePaidAmount=$this->invoiceRepo->getpaidAmount($dto->invoice_id);
            $invoiceTotal=$this->invoiceRepo->getTotal($dto->invoice_id);
            if($invoicePaidAmount==$invoiceTotal){
                $this->invoiceRepo->updateStatus($dto->invoice_id, 'paid');
            }
            if($invoicePaidAmount<$invoiceTotal){
                $this->invoiceRepo->updateStatus($dto->invoice_id, 'partially_paid');
            }
            DB::commit();
            
            return $payment;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
       
       
     }
    public function getContractSummary(int $contractId):array { 
         //contract_id, total_invoiced, total_paid, (outstanding_balance),
        //invoices_count, latest_invoice_date
        $contract=$this->contractRepo->findById($contractId);
        $total_paid=0;
         $total_invoiced=$contract->Invoices()->sum('total');
         $invoices_count=$contract->Invoices()->count();
         $latest_invoice_date=$contract->Invoices()->latest()->first()->created_at->toDateString();
        foreach($contract->Invoices as $invoice){
            $total_paid+=$invoice->payments()->sum('amount');
        }
        $outstanding_balance=number_format($total_invoiced-$total_paid, 2, '.', '');
        return[
            'contract_id'=>$contractId,
            'total_invoiced'=>$total_invoiced,
            'total_paid'=>$total_paid,
            'outstanding_balance'=>$outstanding_balance,
            'invoices_count'=>$invoices_count,
            'latest_invoice_date'=>$latest_invoice_date

        ];
        
    }
    public function getByContractId(int $contractId):Collection { 
       
        return $this->invoiceRepo->getByContractId($contractId);
    }
    public function findById(int $invoiceId):Invoice { 
       
        return $this->invoiceRepo->findById($invoiceId);
    }


    public function generateInvoiceNumber($tenant_id): string {
        //NV-{TENANT_ID}-{YYYYMM}-{SEQUENCE} 00001
        $lastid = Invoice::latest()->first()->id ?? 1;
        return 'INV-' . $tenant_id . '-' . date('Ym') . '-' . sprintf('%04d', $lastid++);
    }
}
