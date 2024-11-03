<?php

namespace Tests\Unit\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Enums\ProductStatus;
use App\Core\Exceptions\InvalidProductStatusException;
use App\Core\UseCases\ListPaginatedProductsUseCase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Mockery;

describe('ListPaginatedProductsUseCase -> execute()', function () {
    beforeEach(function () {
        $this->mockProductRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->useCase = new ListPaginatedProductsUseCase($this->mockProductRepository);
    });

    it('should execute with all valid filters', function () {
        $perPage = 15;
        $search = 'Sample Product';
        $status = ProductStatus::PUBLISHED->value;

        $this->mockProductRepository
            ->expects()
            ->listPaginatedProducts($perPage, $search, $status)
            ->andReturn(Mockery::mock(LengthAwarePaginator::class))
            ->once();

        $result = $this->useCase->execute($search, $status, $perPage);
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('should execute with all empty filters', function () {
        $perPage = 10;
        $search = null;
        $status = null;

        $this->mockProductRepository
            ->expects()
            ->listPaginatedProducts($perPage, $search, $status)
            ->andReturn(Mockery::mock(LengthAwarePaginator::class))
            ->once();

        $result = $this->useCase->execute(search: $search, status: $status);
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('should trim search term before passing it to the repository', function () {
        $perPage = 10;
        $search = '  Sample Product  ';
        $trimmedSearch = 'Sample Product';
        $status = ProductStatus::PUBLISHED->value;

        $this->mockProductRepository
            ->expects()
            ->listPaginatedProducts($perPage, $trimmedSearch, $status)
            ->andReturn(Mockery::mock(LengthAwarePaginator::class))
            ->once();

        $result = $this->useCase->execute(search: $search, status: $status);
        expect($result)->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('should throw an exception when invalid status is provided', function () {
        $this->useCase->execute(search: null, status: 'INVALID_STATUS');
    })->throws(InvalidProductStatusException::class);

    it('should throw a ProductNotFoundException when the product with the given barcode does not exist', function () {
        $perPage = 10;
        $search = null;
        $status = null;

        $this->mockProductRepository
            ->expects()
            ->listPaginatedProducts($perPage, $search, $status)
            ->andThrow(new \Exception('Error getting paginated products.'))
            ->once();

        $this->useCase->execute(search: $search, status: $status);
    })->throws(\Exception::class, 'Error getting paginated products.');
});
