<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'code' => Str::random(10),
            'price' => $this->faker->numberBetween(50, 50000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'unit' => Arr::random(config('enums.unit')),
            'description' => $this->faker->text,
            'status' => 1,
        ];
    }
}
