<?php

namespace App\Core\UseCases;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Core\Exceptions\ProductNotFoundException;

abstract class BaseProductUseCase
{
    public function __construct(protected ProductRepositoryInterface $productRepository) {}

    protected function getProductByBarcode(string $barcode): Product
    {
        $product = $this->productRepository->getProductByBarcode($barcode);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }
}
