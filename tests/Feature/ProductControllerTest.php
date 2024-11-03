<?php

namespace Test\Feature;

use App\Core\Domain\Enums\ProductStatus;
use App\Models\Product as ProductModel;
use Illuminate\Http\Response;

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
