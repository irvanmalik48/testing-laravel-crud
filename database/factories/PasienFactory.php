<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PasienFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'tanggal_lahir' => fake()->date('Y-m-d', '-20 years'),
        ];
    }
}
