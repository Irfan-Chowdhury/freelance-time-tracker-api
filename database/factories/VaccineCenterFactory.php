<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class VaccineCenterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company . ' Vaccine Center',
            'address' => fake()->address,
            'daily_limit' => fake()->numberBetween($min = 50, $max = 200),
        ];
    }
}
