<?php

namespace Tests\Feature\ProductController;

use App\Models\Product;
use Tests\Feature\FeatureTestHelper;

class ProductControllerTestHelper extends FeatureTestHelper
{
    protected $products;

    protected function setUp(): void
    {
        parent::setUp();

        $colors = [
            'red',
            'black',
            'white',
            'blue',
        ];

        $categories = [
            'phone',
            'laptop',
            'tablet',
            'watch',
        ];

        $this->products = collect();

        for ($i = 0; $i < 100; $i++) {
            $color = $colors[array_rand($colors)];
            $category = $categories[array_rand($categories)];

            $this->products->push(
                Product::factory()->create([
                    'properties' => [
                        'color' => $color,
                        'category' => $category,
                        'weight' => fake()->randomFloat(2, 1, 10),
                    ],
                ])
            );
        }
    }
}