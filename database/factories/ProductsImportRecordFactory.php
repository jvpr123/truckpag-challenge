<?php

namespace Database\Factories;

use App\Models\ProductsImportRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsImportRecordFactory extends Factory
{
    protected $model = ProductsImportRecord::class;

    public function definition()
    {
        return [
            'success' => $this->faker->boolean(),
            'imported_file' => $this->faker->lexify('products_??.json.gz'),
        ];
    }
}
