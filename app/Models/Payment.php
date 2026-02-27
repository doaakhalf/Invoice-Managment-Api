<?php

namespace App\Models;

use App\Casts\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_id', 'amount', 'payment_method', 'reference_number', 'paid_at','tenant_id'];

    protected $casts = [
        'payment_method' => PaymentStatus::class,
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function tenant()
    {
        return $this->belongsTo(User::class);
    }
}
