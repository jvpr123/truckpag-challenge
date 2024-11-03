<?php

namespace Test\Feature;

use App\Core\Domain\Enums\ProductStatus;
use App\Models\Product as ProductModel;
use Illuminate\Http\Response;

describe('ProductController -> index()', function () {
    it('should respond with 200 status-code with paginated Products without filters', function () {
        $products = ProductModel::factory()->count(15)->create();
        $route = route('products.list');

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Products found successfully.');
        expect($response['pagination']['total'])->toBe($products->count());
        expect($response['pagination']['data'])->toHaveCount(10);
    });

    it('should respond with 200 status-code with paginated Products using custom perpage param', function () {
        $products = ProductModel::factory()->count(15)->create();
        $route = route('products.list', ['perpage' => 15]);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Products found successfully.');
        expect($response['pagination']['total'])->toBe($products->count());
        expect($response['pagination']['data'])->toHaveCount($products->count());
    });

    it('should respond with 200 status-code with paginated Products filtered by search', function () {
        ProductModel::factory()
            ->count(3)
            ->sequence(
                ['product_name' => 'Apple Juice'],
                ['product_name' => 'Orange Juice'],
                ['product_name' => 'Milk']
            )
            ->create();
        $route = route('products.list', ['search' => 'Juice']);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Products found successfully.');
        expect($response['pagination']['total'])->toBe(2);
        expect($response['pagination']['data'])->toHaveCount(2);
    });

    it('should respond with 200 status-code with paginated Products filtered by status', function () {
        ProductModel::factory()
            ->count(3)
            ->sequence(
                ['status' => ProductStatus::PUBLISHED],
                ['status' => ProductStatus::PUBLISHED],
                ['status' => ProductStatus::DRAFT],
            )
            ->create();
        $route = route('products.list', ['status' => ProductStatus::PUBLISHED->value]);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Products found successfully.');
        expect($response['pagination']['total'])->toBe(2);
        expect($response['pagination']['data'])->toHaveCount(2);
    });

    it('should respond with 200 status-code with paginated Products using all filters', function () {
        ProductModel::factory()
            ->count(3)
            ->sequence(
                ['product_name' => 'Apple Juice', 'status' => ProductStatus::PUBLISHED->value],
                ['product_name' => 'Apple Juice', 'status' => ProductStatus::DRAFT->value],
                ['product_name' => 'Orange Juice', 'status' => ProductStatus::TRASH->value]
            )
            ->create();

        $route = route('products.list', [
            'perpage' => 15,
            'search' => 'Apple',
            'status' => ProductStatus::PUBLISHED->value,
        ]);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Products found successfully.');
        expect($response['pagination']['total'])->toBe(1);
        expect($response['pagination']['data'])->toHaveCount(1);
    });

    it('should respond with 400 status-code with error message when invalid product status is provided', function () {
        $route = route('products.list', ['status' => 'INVALID_STATUS']);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        expect($response['error'])->toBe('Product status must be a valid option: published, draft, trash.');
    });
});

describe('ProductController -> show()', function () {
    it('should respond with 200 with found Product data on success', function () {
        $product = ProductModel::factory()->create();
        $route = route('products.find-by-barcode', ['barcode' => $product->code]);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Product found successfully.');
        expect($response['product']['id'])->toBe($product->id);
        expect($response['product']['code'])->toBe($product->code);
    });

    it('should respond with 404 with error message if Product not found', function () {
        $route = route('products.find-by-barcode', ['barcode' => '00000000']);

        $response = $this->getJson($route);
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson(['error' => 'Product not found.']);
    });
});

describe('ProductController -> update()', function () {
    beforeEach(function () {
        $this->product = ProductModel::factory()->create();
        $this->route = route('products.update', ['barcode' => $this->product->code]);

        $this->bodyData = [
            'status' => ProductStatus::DRAFT->value,
            'stores' => 'Extra, Bretas, Asaí',
            'nutriscoreScore' => 10,
            'nutriscoreGrade' => 'b',
            'url' => 'https://world.openfoodfacts.org/product/20221126',
        ];
    });

    it('should respond with 200 with updated Product data on success', function () {
        $response = $this->putJson($this->route, $this->bodyData);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Product updated successfully.');
        expect($response['product']['id'])->toBe($this->product->id);
        expect($response['product']['code'])->toBe($this->product->code);
    });

    it('should respond with 400 with validation messages on validation error', function () {
        $bodyData = [
            'status' => ProductStatus::TRASH->value,
            'nutriscoreGrade' => 'g',
            'url' => 'world.openfoodfacts.org/product/20221126',
        ];

        $response = $this->putJson($this->route, $bodyData);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $errors = $response['errors'];
        expect($errors['status'][0])->toBe('The status must be a valid option: published, draft.');
        expect($errors['url'][0])->toBe('The url field must be a valid URL.');
        expect($errors['nutriscoreGrade'][0])->toBe("The nutriscoreGrade must be a letter between 'a' and 'e'.");
    });

    it('should respond with 404 with error message if Product not found', function () {
        $route = route('products.update', ['barcode' => '00000000']);

        $response = $this->putJson($route, $this->bodyData);
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson(['error' => 'Product not found.']);
    });
});

describe('ProductController -> delete()', function () {
    beforeEach(function () {
        $this->product = ProductModel::factory()->create();
        $this->route = route('products.delete', ['barcode' => $this->product->code]);
    });

    it('should respond with 200 confirming Product deletion on success', function () {
        $response = $this->deleteJson($this->route);
        $response->assertStatus(Response::HTTP_OK);

        expect($response['message'])->toBe('Product deleted successfully.');

        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'status' => ProductStatus::TRASH->value,
        ]);
    });

    it('should respond with 404 with error message if Product not found', function () {
        $route = route('products.delete', ['barcode' => '00000000']);

        $response = $this->deleteJson($route);
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson(['error' => 'Product not found.']);
    });
});
