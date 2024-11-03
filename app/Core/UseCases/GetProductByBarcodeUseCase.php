<?php

namespace App\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Core\Exceptions\ProductNotFoundException;

class GetProductByBarcodeUseCase
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    public function execute(string $barcode): ?Product
    {
        $product = $this->productRepository->getProductByBarcode($barcode);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }
}
