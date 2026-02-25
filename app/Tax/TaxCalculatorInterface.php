<?php
namespace App\Tax;

interface TaxCalculatorInterface
{
    public function calculate(float $amount): float;
}
