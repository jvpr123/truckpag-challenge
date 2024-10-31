<?php

use App\Http\Controllers\ApiStateController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApiStateController::class, 'index']);

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductsController::class, 'index']);
    Route::get('/{barcode}', [ProductsController::class, 'show']);
    Route::put('/{barcode}', [ProductsController::class, 'update']);
    Route::delete('/{barcode}', [ProductsController::class, 'delete']);
});
