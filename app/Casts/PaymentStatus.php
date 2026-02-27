<?php
namespace App\Casts;

enum  PaymentStatus: string
{
    //enum: cash, bank_transfer, credit_card
    case Cash = 'cash';
    case BankTransfer = 'bank_transfer';
    case CreditCard = 'credit_card';
}