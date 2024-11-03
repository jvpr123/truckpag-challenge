<?php

namespace Tests\Unit\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Core\Exceptions\ProductNotFoundException;
use App\Core\UseCases\DeleteProductUseCase;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;
use Carbon\Carbon;
use Mockery;

describe('DeleteProductUseCase -> execute()', function () {
    beforeEach(function () {
        Carbon::setTestNow(time());

        $this->mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->useCase = new DeleteProductUseCase($this->mockProductRepository);

        $this->productModel = ProductModel::factory()->create();
        $this->productEntity = (new ProductTransformer)->modelToEntity($this->productModel);
    });

    it('should delete (set status to TRASH) a product successfully', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($this->productModel->code)
            ->andReturn($this->productEntity)
            ->once();

        $this->productEntity->setStatus(ProductStatus::TRASH);
        $this->productEntity->setUpdatedAt(time());

        $this->mockProductRepository
            ->expects()
            ->updateProduct($this->productEntity)
            ->once();

        $this->useCase->execute($this->productModel->code);
    });

    it('should throw an exception if product not found', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($this->productModel->code)
            ->andReturnNull()
            ->once();

        $this->useCase->execute($this->productModel->code);
    })->throws(ProductNotFoundException::class);

    it('should throw an exception on updating product error', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($this->productModel->code)
            ->andReturn($this->productEntity)
            ->once();

        $this->mockProductRepository
            ->expects()
            ->updateProduct(Mockery::type(Product::class))
            ->andThrow(new \Exception('Error updating product.'))
            ->once();

        $this->useCase->execute($this->productModel->code);
    })->throws(\Exception::class, 'Error updating product.');
});
