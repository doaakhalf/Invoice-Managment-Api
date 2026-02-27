<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $number = fake()->randomFloat(2, 10, 1000);
        return [
            //
            'invoice_number' => 'INV-'. fake()->numberBetween(1, 100).'-'.Date::now()->format('YYYYMM').'-'.sprintf("%04d", fake()->numberBetween(1, 100)),  //INV-{TENANT_ID}-{YYYYMM}-{SEQUENCE}
            'subtotal'=>number_format($number, 2, '.', ','),
            'tax_amount'=>number_format($number, 2, '.', ','),
            'total'=>number_format($number, 2, '.', ','),
            'status'=>fake()->randomElement(['pending', 'paid','partially_paid','overdue','cancelled']),
            'due_date'=>Date::now()->addDays(15)->format('Y-m-d'),
            'paid_at'=>Date::now()->addDays(15)->format('Y-m-d'),
            'contract_id'=>fake()->numberBetween(1, 2),
            'tenant_id'=>fake()->numberBetween(1, 3)

            

        ];
    }
}
