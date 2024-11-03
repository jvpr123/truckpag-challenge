<?php

namespace App\Http\Controllers;

use App\Core\UseCases\DeleteProductUseCase;
use App\Core\UseCases\DTO\UpdateProductInputDTO;
use App\Core\UseCases\GetProductByBarcodeUseCase;
use App\Core\UseCases\UpdateProductUseCase;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(['messade' => 'List paginated products route']);
    }

    public function show(GetProductByBarcodeUseCase $useCase, string $barcode)
    {
        $product = $useCase->execute($barcode);

        return response()->json([
            'message' => 'Product found successfully.',
            'product' => $product->toArray(),
        ]);
    }

    public function update(
        UpdateProductUseCase $useCase,
        UpdateProductRequest $request,
        string $barcode,
    ) {
        $dto = new UpdateProductInputDTO(
            code: $request->validated('code'),
            status: $request->validated('status'),
            url: $request->validated('url'),
            creator: $request->validated('creator'),
            productName: $request->validated('productName'),
            quantity: $request->validated('quantity'),
            brands: $request->validated('brands'),
            categories: $request->validated('categories'),
            labels: $request->validated('labels'),
            cities: $request->validated('cities'),
            purchasePlaces: $request->validated('purchasePlaces'),
            stores: $request->validated('stores'),
            ingredientsText: $request->validated('ingredientsText'),
            traces: $request->validated('traces'),
            servingSize: $request->validated('servingSize'),
            servingQuantity: $request->validated('servingQuantity'),
            nutriscoreScore: $request->validated('nutriscoreScore'),
            nutriscoreGrade: $request->validated('nutriscoreGrade'),
            mainCategory: $request->validated('mainCategory'),
            imageUrl: $request->validated('imageUrl')
        );

        $product = $useCase->execute($barcode, $dto);

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product->toArray(),
        ]);
    }

    public function delete(DeleteProductUseCase $useCase, string $barcode)
    {
        $useCase->execute($barcode);

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
