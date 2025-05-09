<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 1, 9999),
            'count' => $this->faker->numberBetween(1, 100),
            'properties' => [
                'color' => $this->faker->safeColorName(),
                'weight' => $this->faker->randomFloat(2, 0.1, 10),
                'category' => $this->faker->word(),
            ],
        ];
    }
}
