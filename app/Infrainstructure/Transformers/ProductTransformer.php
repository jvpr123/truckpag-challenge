<?php

namespace App\Infrainstructure\Transformers;

use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Models\Product as ProductModel;
use DateTime;

class ProductTransformer
{
    public function transform(ProductModel $model): Product
    {
        info($model);
        return new Product(
            id: $model->id,
            code: $model->code,
            status: ProductStatus::from($model->status),
            url: $model->url,
            creator: $model->creator,
            productName: $model->product_name,
            quantity: $model->quantity,
            brands: $model->brands,
            categories: $model->categories,
            labels: $model->labels,
            cities: $model->cities,
            purchasePlaces: $model->purchase_places,
            stores: $model->stores,
            ingredientsText: $model->ingredients_text,
            traces: $model->traces,
            servingSize: $model->serving_size,
            serving_quantity: $model->serving_quantity,
            nutriscoreScore: $model->nutriscore_score,
            nutriscoreGrade: $model->nutriscore_grade,
            mainCategory: $model->main_category,
            imageUrl: $model->image_url,
            importedAt: new DateTime($model->imported_t),
            createdAt: $model->created_t,
            updatedAt: $model->last_modified_t
        );
    }
}
