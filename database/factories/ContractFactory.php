<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            //
            'unit_name' => fake()->name(),
            'customer_name' => fake()->name(),
            'rent_amount' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement(['draft', 'active', 'expired', 'terminated']),
            'tenant_id' => fake()->randomNumber(1,4),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
