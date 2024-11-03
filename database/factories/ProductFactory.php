<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'status' => 'published',
            'url' => $this->faker->url,
            'creator' => $this->faker->userName,
            'product_name' => $this->faker->words(3, true),
            'quantity' => $this->faker->randomNumber(3),
            'brands' => $this->faker->company,
            'categories' => implode(', ', $this->faker->words(4)),
            'labels' => implode(', ', $this->faker->words(3)),
            'cities' => $this->faker->city,
            'purchase_places' => $this->faker->city . ',' . $this->faker->country,
            'stores' => $this->faker->company,
            'ingredients_text' => $this->faker->sentence(12),
            'traces' => implode(', ', $this->faker->words(3)),
            'serving_size' => $this->faker->numberBetween(10, 100) . ' g',
            'serving_quantity' => $this->faker->randomFloat(1, 10, 100),
            'nutriscore_score' => $this->faker->numberBetween(1, 30),
            'nutriscore_grade' => $this->faker->randomElement(['a', 'b', 'c', 'd', 'e']),
            'main_category' => 'en:' . $this->faker->word,
            'image_url' => $this->faker->imageUrl(640, 480, 'food'),
            'imported_t' => $this->faker->iso8601,
            'created_t' => $this->faker->unixTime,
            'last_modified_t' => $this->faker->unixTime,
        ];
    }
}
