<?php

namespace App\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Enums\ProductStatus;
use App\Core\Exceptions\InvalidProductStatusException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPaginatedProductsUseCase
{
    public function __construct(protected ProductRepositoryInterface $productRepository) {}

    public function execute(?string $search, ?string $status, int $perpage = 10): LengthAwarePaginator
    {
        $status = $this->parseProductStatus($status);
        $search = $this->sanitizeSearch($search);

        return $this->productRepository->listPaginatedProducts(
            perpage: $perpage,
            search: $search,
            status: $status,
        );
    }

    private function parseProductStatus(?string $status): ?string
    {
        if (!$status) return null;

        try {
            return ProductStatus::from($status)->value;
        } catch (\Throwable) {
            throw new InvalidProductStatusException();
        }
    }

    private function sanitizeSearch(?string $search): ?string
    {
        if (!$search) return null;

        return trim($search);
    }
}
