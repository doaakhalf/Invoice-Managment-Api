<?php

namespace App\Providers;

use App\Tax\TaxCalculatorInterface;
use App\Tax\TaxTypes\MunicipalFee;
use App\Tax\TaxTypes\VAT;
use Illuminate\Support\ServiceProvider;

class TaxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->when(Vat::class)
        ->needs(TaxCalculatorInterface::class)
        ->give(Vat::class);

        $this->app->when(MunicipalFee::class)
        ->needs(TaxCalculatorInterface::class)
        ->give(MunicipalFee::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
