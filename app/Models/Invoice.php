<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['invoice_number','subtotal','tax_amount','total','status','due_date','paid_at','contract_id'];



    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
