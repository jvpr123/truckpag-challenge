<?php

namespace Tests\Unit\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Core\UseCases\GetProductByBarcodeUseCase;
use Mockery;
use ProductNotFoundException;

describe('GetProductByBarcodeUseCase -> execute()', function () {
    beforeEach(function () {
        $this->mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->useCase = new GetProductByBarcodeUseCase($this->mockProductRepository);

        $this->barcode = '20221126';
        $this->product = Mockery::mock(Product::class);
    });

    it('should return a Product when the product with the given barcode exists', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($this->barcode)
            ->andReturn($this->product)
            ->once();

        $output = $this->useCase->execute($this->barcode);
        expect($output)->toBe($this->product);
    });

    it('should throw a ProductNotFoundException when the product with the given barcode does not exist', function () {
        $this->mockProductRepository
            ->expects()
            ->getProductByBarcode($otherBarcode = '00000000')
            ->andReturnNull()
            ->once();

        $this->useCase->execute($otherBarcode);
    })->throws(ProductNotFoundException::class, 'Product not found.');
});
