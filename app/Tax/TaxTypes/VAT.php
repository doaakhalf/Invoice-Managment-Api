<?php
namespace  App\Tax\TaxTypes;

use App\Tax\TaxCalculatorInterface;

class VAT implements TaxCalculatorInterface{

    public function calculate(float $amount): float
    {
        return $amount * 0.15;
    }
}
