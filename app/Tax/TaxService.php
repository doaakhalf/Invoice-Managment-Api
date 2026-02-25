<?php
namespace App\Tax;

class TaxService
{
    protected TaxCalculatorInterface $taxCalculator;

   
    public function setTaxCalculator(TaxCalculatorInterface $taxCalculator): void
    {
        $this->taxCalculator = $taxCalculator;
    }

    public function calculate(float $amount): float
    {
        return $this->taxCalculator->calculate($amount);
    }
}