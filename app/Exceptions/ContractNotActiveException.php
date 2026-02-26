<?php

namespace App\Exceptions;

use Exception;

class ContractNotActiveException extends Exception
{
    //

    public function __construct($message = "Contract is not active")
    {
        parent::__construct($message);
        return response()->json([
            'message' => $message,
        ], 400);
    }
}
