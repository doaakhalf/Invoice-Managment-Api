<?php
namespace App\Casts;

enum  InvoiceStatus: string
{
    //enum:pending, paid, partially_paid, overdue, cancelled), due_date, paid_at
    case Pending = 'pending';
    case Paid = 'paid';
    case PartiallyPaid = 'partially_paid';
    case Overdue = 'overdue';
    case Cancelled = 'cancelled';
}