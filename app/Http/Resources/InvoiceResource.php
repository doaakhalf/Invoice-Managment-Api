<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        // id, invoice_number, subtotal, tax_amount, total, status, due_date,
        // paid_at, remaining_balance (computed), contract (whenLoaded), payments (whenLoaded)
        return [
            'id'=>$this->id,
            'invoice_number'=>$this->invoice_number,
            'subtotal'=>$this->subtotal,
            'tax_amount'=>$this->tax_amount,
            'total'=>$this->total,
            'status'=>$this->status,
            'due_date'=>$this->due_date,
            'paid_at'=>$this->paid_at,
            'remaining_balance'=>$this->remaining_balance,
            'contract'=>$this->contract,
            'payments'=>$this->payments,

        ];
    }
   
}
