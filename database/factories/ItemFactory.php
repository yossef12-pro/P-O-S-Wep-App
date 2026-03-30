<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'name' => $this->faker->words(nb: 2, asText: true),
        'sku' => Str::upper(value: Str::random(length: 10)),
        'price' => $this->faker->randomNumber(2),
        'status' => 'active',
    ];
}
}
