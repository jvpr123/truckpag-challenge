<?php

namespace App\Infrainstructure\Transformers;

use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Models\Product as ProductModel;
use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductTransformer
{
    public function modelToEntity(ProductModel $model): Product
    {
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

    public function entityToModel(Product $entity): ProductModel
    {
        $model = new ProductModel();

        $model->id = $entity->getId();
        $model->code = $entity->getCode();
        $model->status = $entity->getStatus()->value;
        $model->url = $entity->getUrl();
        $model->creator = $entity->getCreator();
        $model->product_name = $entity->getProductName();
        $model->quantity = $entity->getQuantity();
        $model->brands = $entity->getBrands();
        $model->categories = $entity->getCategories();
        $model->labels = $entity->getLabels();
        $model->cities = $entity->getCities();
        $model->purchase_places = $entity->getPurchasePlaces();
        $model->stores = $entity->getStores();
        $model->ingredients_text = $entity->getIngredientsText();
        $model->traces = $entity->getTraces();
        $model->serving_size = $entity->getServingSize();
        $model->serving_quantity = $entity->getServingQuantity();
        $model->nutriscore_score = $entity->getNutriscoreScore();
        $model->nutriscore_grade = $entity->getNutriscoreGrade();
        $model->main_category = $entity->getMainCategory();
        $model->image_url = $entity->getImageUrl();
        $model->imported_t = $entity->getImportedAt();
        $model->created_t = $entity->getCreatedAt();
        $model->last_modified_t = $entity->getUpdatedAt();

        return $model;
    }

    public function transformPagination(LengthAwarePaginator $pagination): LengthAwarePaginator
    {
        $transformedCollection = $pagination->getCollection()->transform(function (ProductModel $productModel) {
            return $this->modelToEntity($productModel)->toArray();
        });

        return $pagination->setCollection($transformedCollection);
    }
}
