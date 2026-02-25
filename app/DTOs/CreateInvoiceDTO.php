<?php
namespace App\DTOs;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Contract;

class CreateInvoiceDTO{

    public readonly int $contract_id;
    public readonly string $due_date;
    public readonly int $tenant_id;
    


    public function __construct(int $contract_id, string $due_date,int $tenant_id)
    {
        $this->contract_id = $contract_id;
        $this->due_date = $due_date;
        $this->tenant_id = $tenant_id;
     
    
    }

    public static function formRequest(StoreInvoiceRequest $request,Contract $contract): self {
        return new self(
        contract_id: $contract->id,
        due_date: date('Y-m-d', strtotime($request->validated('due_date'))),
        tenant_id: $request->user()->tenant_id,
       
       
        );
 }


}









