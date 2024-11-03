<?php

namespace App\Core\UseCases;

use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Core\UseCases\DTO\UpdateProductInputDTO;

class UpdateProductUseCase extends BaseProductUseCase
{
    public function execute(string $barcode, UpdateProductInputDTO $dto): Product
    {
        $product = $this->getProductByBarcode($barcode);

        $updatedProduct = $this->getProductToUpdate($product, $dto);
        $this->productRepository->updateProduct($updatedProduct);

        return $updatedProduct;
    }

    private function getProductToUpdate(Product $product, UpdateProductInputDTO $dto): Product
    {
        return new Product(
            id: $product->getId(),
            code: $dto->code ?: $product->getCode(),
            status: $dto->status ? ProductStatus::from($dto->status) : $product->getStatus(),
            url: $dto->url ?: $product->getUrl(),
            creator: $dto->creator ?: $product->getCreator(),
            productName: $dto->productName ?: $product->getProductName(),
            quantity: $dto->quantity ?: $product->getQuantity(),
            brands: $dto->brands ?: $product->getBrands(),
            categories: $dto->categories ?: $product->getCategories(),
            labels: $dto->labels ?: $product->getLabels(),
            cities: $dto->cities ?: $product->getCities(),
            purchasePlaces: $dto->purchasePlaces ?: $product->getPurchasePlaces(),
            stores: $dto->stores ?: $product->getStores(),
            ingredientsText: $dto->ingredientsText ?: $product->getIngredientsText(),
            traces: $dto->traces ?: $product->getTraces(),
            servingSize: $dto->servingSize ?: $product->getServingSize(),
            serving_quantity: $dto->servingQuantity ?: $product->getServingQuantity(),
            nutriscoreScore: $dto->nutriscoreScore ?: $product->getNutriscoreScore(),
            nutriscoreGrade: $dto->nutriscoreGrade ?: $product->getNutriscoreGrade(),
            mainCategory: $dto->mainCategory ?: $product->getMainCategory(),
            imageUrl: $dto->imageUrl ?: $product->getImageUrl(),
            importedAt: $product->getImportedAt(),
            createdAt: $product->getCreatedAt(),
            updatedAt: time()
        );
    }
}
