<?php

namespace App\Providers;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Contracts\Repositories\ProductsImportRecordRepositoryInterface;
use App\Infrainstructure\Repositories\ProductRepository;
use App\Infrainstructure\Repositories\ProductsImportRecordRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductsImportRecordRepositoryInterface::class, ProductsImportRecordRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
