<?php

namespace Test\Feature;

use App\Models\Product as ProductModel;
use Illuminate\Http\Response;

describe('ProductController -> show()', function () {
    it('should respond with 200 with found Product data', function () {
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
