<?php

namespace Tests\Unit\Infrastructure\Transformers;

use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;
use DateTime;

describe('ProductTransformer -> transform()', function () {
    it('should transform a Product Eloquent model into a Product entity correctly', function () {
        $productModel = ProductModel::factory()->create();
        $productEntity = (new ProductTransformer())->transform($productModel);

        expect($productEntity)->toBeInstanceOf(Product::class);
        expect($productEntity->getId())->toBe($productModel->id);
        expect($productEntity->getCode())->toBe($productModel->code);
        expect($productEntity->getStatus())->toBe(ProductStatus::from($productModel->status));
        expect($productEntity->getUrl())->toBe($productModel->url);
        expect($productEntity->getCreator())->toBe($productModel->creator);
        expect($productEntity->getProductName())->toBe($productModel->product_name);
        expect($productEntity->getQuantity())->toBe($productModel->quantity);
        expect($productEntity->getBrands())->toBe($productModel->brands);
        expect($productEntity->getCategories())->toBe($productModel->categories);
        expect($productEntity->getLabels())->toBe($productModel->labels);
        expect($productEntity->getCities())->toBe($productModel->cities);
        expect($productEntity->getPurchasePlaces())->toBe($productModel->purchase_places);
        expect($productEntity->getStores())->toBe($productModel->stores);
        expect($productEntity->getIngredientsText())->toBe($productModel->ingredients_text);
        expect($productEntity->getTraces())->toBe($productModel->traces);
        expect($productEntity->getServingSize())->toBe($productModel->serving_size);
        expect($productEntity->getServingQuantity())->toBe($productModel->serving_quantity);
        expect($productEntity->getNutriscoreScore())->toBe($productModel->nutriscore_score);
        expect($productEntity->getNutriscoreGrade())->toBe($productModel->nutriscore_grade);
        expect($productEntity->getMainCategory())->toBe($productModel->main_category);
        expect($productEntity->getImageUrl())->toBe($productModel->image_url);

        expect($productEntity->getImportedAt())->toBeInstanceOf(DateTime::class);
        expect($productEntity->getImportedAt()->format(DateTime::ATOM))->toBe((new DateTime($productModel->imported_t))->format(DateTime::ATOM));
        expect($productEntity->getCreatedAt())->toBe($productModel->created_t);
        expect($productEntity->getUpdatedAt())->toBe($productModel->last_modified_t);
    });
});
