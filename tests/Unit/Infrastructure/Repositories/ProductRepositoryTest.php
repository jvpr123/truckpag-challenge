<?php

namespace Tests\Unit\Infrastructure\Repositories;

use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Infrainstructure\Repositories\ProductRepository;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;
use Mockery;

describe('ProductRepository -> getProductByBarcode()', function () {
    beforeEach(function () {
        $this->productTransformer = new ProductTransformer;
        $this->productRepository = new ProductRepository($this->productTransformer);
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

describe('ProductRepository -> update()', function () {
    beforeEach(function () {
        $this->mockProductTransformer = Mockery::mock(ProductTransformer::class)->makePartial();
        $this->productRepository = new ProductRepository($this->mockProductTransformer);

        $this->productModel = ProductModel::factory()->create();
        $this->productEntity = (new ProductTransformer)->modelToEntity($this->productModel);
    });

    it('updates the product when it exists', function () {
        $this->productEntity->setCode($updatedCode = '12345678');
        $this->productEntity->setStatus($updatedStatus = ProductStatus::DRAFT);

        $this->productModel->code = $updatedCode;
        $this->productModel->status = $updatedStatus;

        $this->mockProductTransformer
            ->expects()
            ->entityToModel($this->productEntity)
            ->andReturn($this->productModel)
            ->once();

        $this->productRepository->updateProduct($this->productEntity);

        $this->assertDatabaseHas('products', [
            'id' => $this->productEntity->getId(),
            'code' => $updatedCode,
            'status' => $updatedStatus,
        ]);
    });

    it('should throw an exception on product transformer error', function () {
        $this->mockProductTransformer
            ->expects()
            ->entityToModel($this->productEntity)
            ->andThrow(new \Exception('Error updating product.'))
            ->once();

        $this->productRepository->updateProduct($this->productEntity);
    })->throws(\Exception::class, 'Error updating product.');
});
