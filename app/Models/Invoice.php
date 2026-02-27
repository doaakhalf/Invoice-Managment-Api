<?php

namespace App\Models;

use App\Casts\InvoiceStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([TenantScope::class])]
class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['invoice_number','subtotal','tax_amount','total','status','due_date','paid_at','contract_id','tenant_id'];

  protected $casts = [
    'status' => InvoiceStatus::class,
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

}
