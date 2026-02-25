<?php
namespace App\DTOs;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Invoice;

class RecordPaymentDTO{

    public readonly int $invoice_id;
    public readonly float $amount;
    public readonly string $payment_method;
    public readonly string $reference_number;
    
   

    public function __construct(int $invoice_id, float $amount,string $payment_method,string $reference_number)
    {
        $this->invoice_id = $invoice_id;
        $this->amount = $amount;
        $this->payment_method = $payment_method;
        $this->reference_number = $reference_number;
    
    }

    public static function formRequest(StorePaymentRequest $request,Invoice $invoice): self {
      
        return new self(
            invoice_id:$invoice->id,
            amount:$request->validated('amount'),
            payment_method:$request->validated('payment_method'),
            reference_number:$request->validated('reference_number'),
        );
 }


}









