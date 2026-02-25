<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['unit_name', 'customer_name', 'rent_amount', 'status', 'tenant_id','start_date','end_date'];

    public function tenant()
    {
        return $this->belongsTo(User::class);
    }
    public function Invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
