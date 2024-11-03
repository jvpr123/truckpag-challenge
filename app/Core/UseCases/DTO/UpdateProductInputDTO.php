<?php

namespace App\Core\UseCases\DTO;

class UpdateProductInputDTO
{
    public function __construct(
        public ?string $code = null,
        public ?string $status = null,
        public ?string $url = null,
        public ?string $creator = null,
        public ?string $productName = null,
        public ?int $quantity = null,
        public ?string $brands = null,
        public ?string $categories = null,
        public ?string $labels = null,
        public ?string $cities = null,
        public ?string $purchasePlaces = null,
        public ?string $stores = null,
        public ?string $ingredientsText = null,
        public ?string $traces = null,
        public ?string $servingSize = null,
        public ?string $servingQuantity = null,
        public ?string $nutriscoreScore = null,
        public ?string $nutriscoreGrade = null,
        public ?string $mainCategory = null,
        public ?string $imageUrl = null,
    ) {}
}
