<?php

namespace Tests\Unit\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Core\Exceptions\ProductNotFoundException;
use App\Core\UseCases\DTO\UpdateProductInputDTO;
use App\Core\UseCases\UpdateProductUseCase;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;
use Carbon\Carbon;
use Mockery;

describe('UpdateProductUseCase -> execute()', function () {
    beforeEach(function () {
        Carbon::setTestNow(time());

        $this->mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->useCase = new UpdateProductUseCase($this->mockProductRepository);

        $this->productModel = ProductModel::factory()->create();
        $this->productEntity = (new ProductTransformer)->modelToEntity($this->productModel);

        $this->inputDTO = new UpdateProductInputDTO(
            code: $this->productModel->code,
            status: 'draft',
            creator: 'Product Creator',
        );
    });

    it('should update a product successfully', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($this->productModel->code)
            ->andReturn($this->productEntity)
            ->once();

        $this->mockProductRepository
            ->expects()
            ->updateProduct(Mockery::type(Product::class))
            ->once();

        $output = $this->useCase->execute($this->productModel->code, $this->inputDTO);
        expect($output)->toBeInstanceOf(Product::class);
        expect($output->getId())->toBe($this->productEntity->getId());
        expect($output->getCode())->toBe($this->productEntity->getCode());
        expect($output->getStatus())->toBe(ProductStatus::DRAFT);
        expect($output->getCreator())->toBe('Product Creator');
        expect($output->getUpdatedAt())->toBe(time());
    });

    it('should throw an exception if product not found', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($this->productModel->code)
            ->andReturnNull()
            ->once();

        $this->useCase->execute($this->productModel->code, $this->inputDTO);
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

        $this->useCase->execute($this->productModel->code, $this->inputDTO);
    })->throws(\Exception::class, 'Error updating product.');
});
