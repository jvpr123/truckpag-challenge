<?php

namespace App\Core\Contracts\Repositories;

use App\Core\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    // function listPaginatedProducts(): array;

    public function getProductByBarcode(string $barcode): ?Product;

    public function updateProduct(Product $product): void;
}
