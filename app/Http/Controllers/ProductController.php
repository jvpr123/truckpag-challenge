<?php

namespace App\Http\Controllers;

use App\Core\UseCases\GetProductByBarcodeUseCase;
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
            'product' => $product,
        ]);
    }

    public function update(Request $request, string $barcode)
    {
        return response()->json([
            'message' => 'Update product by barcode route',
            'barcode' => $barcode,
        ]);
    }

    public function delete(Request $request, string $barcode)
    {
        return response()->json([
            'message' => 'Trash product by barcode route',
            'barcode' => $barcode,
        ]);
    }
}
