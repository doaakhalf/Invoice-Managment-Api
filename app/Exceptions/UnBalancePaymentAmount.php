<?php

namespace App\Exceptions;

use Exception;

class UnBalancePaymentAmount extends Exception
{
    //
    public function __construct($message = "Payment amount is greater than remaining balance") {
        parent::__construct($message);
        return response()->json([
            'message' => $message,
        ], 400);
    }
}
