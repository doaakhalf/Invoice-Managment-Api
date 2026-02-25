<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'invoice_id'=>fake()->numberBetween(1, 2),
            'amount'=>number_format($number, 2, '.', ','),
            'payment_method'=>fake()->randomElement(['cash', 'bank_transfer','credit_card']),
            'reference_number'=>fake()->numberBetween(1, 1000),
            'paid_at'=>fake()->date('Y-m-d'),
            //
        ];
    }
}
