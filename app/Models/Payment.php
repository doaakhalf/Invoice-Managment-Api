<?php

namespace App\Models;

use App\Casts\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_id', 'amount', 'payment_method', 'reference_number', 'paid_at'];

    protected $casts = [
        'payment_method' => PaymentStatus::class,
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
