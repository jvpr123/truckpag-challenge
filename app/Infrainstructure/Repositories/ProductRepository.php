<?php

namespace App\Infrainstructure\Repositories;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private ProductTransformer $productTransformer) {}

    public function listPaginatedProducts(int $perpage, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $pagination = ProductModel::when($search, function ($query, string $search) {
            $query->where('product_name', 'like', "%$search%");
        })
            ->when($status, function ($query, string $status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_t')
            ->paginate($perpage)
            ->withQueryString();

        return $this->productTransformer->transformPagination($pagination);
    }

    public function getProductByBarcode(string $barcode): ?Product
    {
        $product = ProductModel::firstWhere('code', $barcode);

        return $product ? $this->productTransformer->modelToEntity($product) : null;
    }

    public function updateProduct(Product $product): void
    {
        $updatedProduct = $this->productTransformer->entityToModel($product);
        ProductModel::where('id', $product->getId())->update($updatedProduct->toArray());
    }
}
