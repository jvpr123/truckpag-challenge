<?php

namespace Tests\Unit\Infrastructure\Repositories;

use App\Core\Domain\Entities\Product;
use App\Infrainstructure\Repositories\ProductRepository;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;

describe('ProductRepository -> getProductByBarcode()', function () {
    beforeEach(function () {
        $this->mockProductTransformer = new ProductTransformer;
        $this->productRepository = new ProductRepository($this->mockProductTransformer);
    });

    it('should return NULL if product not found', function () {
        $output = $this->productRepository->getProductByBarcode('00000');
        expect($output)->toBeNull();
    });

    it('should return a Product entity instance successfully', function () {
        $product = ProductModel::factory()->create();

        $output = $this->productRepository->getProductByBarcode($product->code);
        expect($output)->toBeInstanceOf(Product::class);
        expect($output->getId())->toBe($product->id);
    });
});
