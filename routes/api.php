<?php

use App\Http\Controllers\ApiStateController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApiStateController::class, 'index']);

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.list');
    Route::get('/{barcode}', [ProductController::class, 'show'])->name('products.find-by-barcode');
    Route::put('/{barcode}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{barcode}', [ProductController::class, 'delete'])->name('products.delete');
});
