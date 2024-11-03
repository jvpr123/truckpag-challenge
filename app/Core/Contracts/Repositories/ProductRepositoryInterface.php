<?php

namespace App\Core\Contracts\Repositories;

use App\Core\Domain\Entities\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function listPaginatedProducts(int $perpage, string $search, string $status): LengthAwarePaginator;

    public function getProductByBarcode(string $barcode): ?Product;

    public function updateProduct(Product $product): void;
}
