<?php

namespace Tests\Unit\Infrastructure\Transformers;

use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Infrainstructure\Transformers\ProductTransformer;
use App\Models\Product as ProductModel;
use DateTime;
use Illuminate\Pagination\LengthAwarePaginator;

describe('ProductTransformer -> modelToEntity()', function () {
    it('should transform a Product Eloquent model into a Product entity correctly', function () {
        $productModel = ProductModel::factory()->create();
        $productEntity = (new ProductTransformer())->modelToEntity($productModel);

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

describe('ProductTransformer -> entityToModel()', function () {
    it('should transform a Product Entity into a Eloquent model correctly', function () {
        $productEntity = new Product(
            id: 1,
            code: '11111111',
            status: ProductStatus::PUBLISHED,
            url: 'http://example.com/product/1',
            creator: 'John Doe',
            productName: 'Example Product',
            quantity: 100,
            brands: 'Brand A',
            categories: 'Category A',
            labels: 'Label A',
            cities: 'City A',
            purchasePlaces: 'Store A',
            stores: 'Store A',
            ingredientsText: 'Water, Sugar',
            traces: 'None',
            servingSize: '250ml',
            serving_quantity: '1',
            nutriscoreScore: 'A',
            nutriscoreGrade: 'A',
            mainCategory: 'Beverages',
            imageUrl: 'http://example.com/image.jpg',
            importedAt: new DateTime('2024-01-01'),
            createdAt: time(),
            updatedAt: time(),
        );

        $productModel = (new ProductTransformer())->entityToModel($productEntity);

        $this->assertInstanceOf(ProductModel::class, $productModel);
        $this->assertEquals($productEntity->getId(), $productModel->id);
        $this->assertEquals($productEntity->getCode(), $productModel->code);
        $this->assertEquals($productEntity->getStatus()->value, $productModel->status);
        $this->assertEquals($productEntity->getUrl(), $productModel->url);
        $this->assertEquals($productEntity->getCreator(), $productModel->creator);
        $this->assertEquals($productEntity->getProductName(), $productModel->product_name);
        $this->assertEquals($productEntity->getQuantity(), $productModel->quantity);
        $this->assertEquals($productEntity->getBrands(), $productModel->brands);
        $this->assertEquals($productEntity->getCategories(), $productModel->categories);
        $this->assertEquals($productEntity->getLabels(), $productModel->labels);
        $this->assertEquals($productEntity->getCities(), $productModel->cities);
        $this->assertEquals($productEntity->getPurchasePlaces(), $productModel->purchase_places);
        $this->assertEquals($productEntity->getStores(), $productModel->stores);
        $this->assertEquals($productEntity->getIngredientsText(), $productModel->ingredients_text);
        $this->assertEquals($productEntity->getTraces(), $productModel->traces);
        $this->assertEquals($productEntity->getServingSize(), $productModel->serving_size);
        $this->assertEquals($productEntity->getServingQuantity(), $productModel->serving_quantity);
        $this->assertEquals($productEntity->getNutriscoreScore(), $productModel->nutriscore_score);
        $this->assertEquals($productEntity->getNutriscoreGrade(), $productModel->nutriscore_grade);
        $this->assertEquals($productEntity->getMainCategory(), $productModel->main_category);
        $this->assertEquals($productEntity->getImageUrl(), $productModel->image_url);
        $this->assertEquals($productEntity->getImportedAt(), $productModel->imported_t);
        $this->assertEquals(time(), $productModel->created_t);
        $this->assertEquals(time(), $productModel->last_modified_t);
    });
});

describe('ProductTransformer -> transformPagination()', function () {
    it('should transforms paginated Product model items to Product entities', function () {
        $productModels = ProductModel::factory()->count(2)->create();
        $pagination = new LengthAwarePaginator($productModels, 2, 2);
        $transformer = new ProductTransformer();

        $transformedPagination = $transformer->transformPagination($pagination);
        expect($transformedPagination)->toBeInstanceOf(LengthAwarePaginator::class);
        expect($transformedPagination->items())->each->toBeArray();
    });
});
