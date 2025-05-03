<?php

namespace Tests\Feature\ProductController;

class ProductControllerCoverTests extends ProductControllerTestHelper
{
    public function testProducts()
    {
        $response = $this->getJson('/products');

        $response->assertStatus(200);
        $response->assertJsonCount(40, 'data');

        $response->assertJsonFragment([
            'id' => $this->products[0]->id,
            'name' => $this->products[0]->name,
        ]);
    }

    public function testFilterByProperties()
    {
        $randomProduct = fake()->randomElement($this->products->toArray());

        $randomColor = $randomProduct['properties']['color'];
        $randomProductCategory = $randomProduct['properties']['category'];
        $query = http_build_query([
            'properties' => [
                'color' => [$randomColor],
                'category' => [$randomProductCategory],
            ],
        ]);

        $response = $this->getJson('/products?' . $query);

        dd($randomProduct, $response->content());
        $response->assertStatus(200);

        // можно дополнительно проверить, что ни один из продуктов не содержит несоответствующих значений
        $responseData = $response->json('data');
        foreach ($responseData as $product) {
            $this->assertContains($product['properties']['color'], [$randomColor]);
            $this->assertContains($product['properties']['category'], [$randomProductCategory]);
        }
    }
}