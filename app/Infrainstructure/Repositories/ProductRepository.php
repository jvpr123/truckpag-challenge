<?php

namespace App\Infrainstructure\Repositories;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private ProductTransformer $productTransformer) {}

    public function getProductByBarcode(string $barcode): ?Product
    {
        $product = ProductModel::firstWhere('code', $barcode);

        return $product ? $this->productTransformer->modelToEntity($product) : null;
    }

    public function updateProduct(Product $product): void
    {
        ProductModel::where('id', $product->getId())->update($product->toArray());
    }
}
