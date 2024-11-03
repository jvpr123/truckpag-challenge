<?php

namespace App\Core\UseCases;

use App\Core\Domain\Enums\ProductStatus;

class DeleteProductUseCase extends BaseProductUseCase
{
    public function execute(string $barcode): void
    {
        $product = $this->getProductByBarcode($barcode);

        $product->setStatus(ProductStatus::TRASH);
        $product->setUpdatedAt(time());

        $this->productRepository->updateProduct($product);
    }
}
