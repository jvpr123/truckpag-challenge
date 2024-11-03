<?php

namespace App\Core\UseCases;

use App\Core\Domain\Entities\Product;

class GetProductByBarcodeUseCase extends BaseProductUseCase
{
    public function execute(string $barcode): Product
    {
        $product = $this->getProductByBarcode($barcode);
        return $product;
    }
}
