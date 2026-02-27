<?php

namespace App\Policies;

use App\Casts\InvoiceStatus;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
   
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        //
      
     
        return $user->id === $invoice->contract->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,Contract $contract): bool
    {
       
        return $user->id === $contract->tenant_id;
    }

      /**
     * Determine whether the user can create models.
     */
    public function recordPayment(User $user,Invoice $invoice): bool
    {
       
            return ($user->id === $invoice->contract->tenant_id) && ($invoice->status!==InvoiceStatus::Cancelled);
    }
    public function getContractSummary(User $user,Contract $contract): bool
    {
       
            return $user->id === $contract->tenant_id;
    }
 
   
}
