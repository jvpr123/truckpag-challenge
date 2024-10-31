<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return response()->json(['messade' => 'List paginated products route']);
    }

    public function show(string $barcode)
    {
        return response()->json([
            'message' => 'Get product by barcode route',
            'barcode' => $barcode,
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
