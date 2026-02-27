<?php
namespace App\Casts;

enum  ContractStatus: string
{
    //draft, active, expired, terminated
    case Draft = 'draft';
    case Active = 'active';
    case Expired = 'expired';
    case Terminated = 'terminated';
}