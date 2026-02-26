<?php

namespace App\Policies;

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
     
        return $user->tenant_id === $invoice->contract->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user,Contract $contract): bool
    {
       
        return $user->tenant_id === $contract->tenant_id ;
    }

      /**
     * Determine whether the user can create models.
     */
    public function recordPayment(User $user,Invoice $invoice): bool
    {
       
            return ($user->tenant_id === $invoice->contract->tenant_id) && ($invoice->status!=='cancelled');
    }
 
   
}
