<?php

namespace App\Core\Contracts\Repositories;

use App\Core\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    function getProductByBarcode(string $barcode): ?Product;
    // function listPaginatedProducts(): array;
    // function updateProduct(Product $product): void;
    // function deleteProduct(int $id): void;
}
