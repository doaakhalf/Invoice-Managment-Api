<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         //contract_id, total_invoiced, total_paid, outstanding_balance,
        //invoices_count, latest_invoice_date
        return [

            'contract_id'=>$this->contract_id,
            'total_invoiced'=>number_format($this->total_invoiced, 2, '.', ''),
            'total_paid'=>number_format($this->total_paid, 2, '.', ''),
            'outstanding_balance'=>number_format($this->outstanding_balance, 2, '.', ''),
            'invoices_count'=>$this->invoices_count,
            'latest_invoice_date'=>$this->latest_invoice_date
        ];
    }
}
