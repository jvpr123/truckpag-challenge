<?php

namespace App\Core\Domain\Entities;

use App\Core\Domain\Enums\ProductStatus;
use DateTime;

class Product
{
    public function __construct(
        private ?int $id,
        private string $code,
        private ProductStatus $status,
        private string $url,
        private string $creator,
        private string $productName,
        private int $quantity,
        private string $brands,
        private string $categories,
        private string $labels,
        private string $cities,
        private string $purchasePlaces,
        private string $stores,
        private string $ingredientsText,
        private string $traces,
        private string $servingSize,
        private string $serving_quantity,
        private string $nutriscoreScore,
        private string $nutriscoreGrade,
        private string $mainCategory,
        private string $imageUrl,
        private DateTime $importedAt,
        private int $createdAt,
        private int $updatedAt,
    ) {}

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getStatus(): ProductStatus
    {
        return $this->status;
    }
    public function setStatus(ProductStatus $status): void
    {
        $this->status = $status;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }
    public function setCreator(string $creator): void
    {
        $this->creator = $creator;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }
    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getBrands(): string
    {
        return $this->brands;
    }
    public function setBrands(string $brands): void
    {
        $this->brands = $brands;
    }

    public function getCategories(): string
    {
        return $this->categories;
    }
    public function setCategories(string $categories): void
    {
        $this->categories = $categories;
    }

    public function getLabels(): string
    {
        return $this->labels;
    }
    public function setLabels(string $labels): void
    {
        $this->labels = $labels;
    }

    public function getCities(): string
    {
        return $this->cities;
    }
    public function setCities(string $cities): void
    {
        $this->cities = $cities;
    }

    public function getPurchasePlaces(): string
    {
        return $this->purchasePlaces;
    }
    public function setPurchasePlaces(string $purchasePlaces): void
    {
        $this->purchasePlaces = $purchasePlaces;
    }

    public function getStores(): string
    {
        return $this->stores;
    }
    public function setStores(string $stores): void
    {
        $this->stores = $stores;
    }

    public function getIngredientsText(): string
    {
        return $this->ingredientsText;
    }
    public function setIngredientsText(string $ingredientsText): void
    {
        $this->ingredientsText = $ingredientsText;
    }

    public function getTraces(): string
    {
        return $this->traces;
    }
    public function setTraces(string $traces): void
    {
        $this->traces = $traces;
    }

    public function getServingSize(): string
    {
        return $this->servingSize;
    }
    public function setServingSize(string $servingSize): void
    {
        $this->servingSize = $servingSize;
    }

    public function getServingQuantity(): string
    {
        return $this->serving_quantity;
    }
    public function setServingQuantity(string $serving_quantity): void
    {
        $this->serving_quantity = $serving_quantity;
    }

    public function getNutriscoreScore(): string
    {
        return $this->nutriscoreScore;
    }
    public function setNutriscoreScore(string $nutriscoreScore): void
    {
        $this->nutriscoreScore = $nutriscoreScore;
    }

    public function getNutriscoreGrade(): string
    {
        return $this->nutriscoreGrade;
    }
    public function setNutriscoreGrade(string $nutriscoreGrade): void
    {
        $this->nutriscoreGrade = $nutriscoreGrade;
    }

    public function getMainCategory(): string
    {
        return $this->mainCategory;
    }
    public function setMainCategory(string $mainCategory): void
    {
        $this->mainCategory = $mainCategory;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getImportedAt(): DateTime
    {
        return $this->importedAt;
    }
    public function setImportedAt(DateTime $importedAt): void
    {
        $this->importedAt = $importedAt;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }
    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(int $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->status->value,
            'url' => $this->url,
            'creator' => $this->creator,
            'productName' => $this->productName,
            'quantity' => $this->quantity,
            'brands' => $this->brands,
            'categories' => $this->categories,
            'labels' => $this->labels,
            'cities' => $this->cities,
            'purchasePlaces' => $this->purchasePlaces,
            'stores' => $this->stores,
            'ingredientsText' => $this->ingredientsText,
            'traces' => $this->traces,
            'servingSize' => $this->servingSize,
            'serving_quantity' => $this->serving_quantity,
            'nutriscoreScore' => $this->nutriscoreScore,
            'nutriscoreGrade' => $this->nutriscoreGrade,
            'mainCategory' => $this->mainCategory,
            'imageUrl' => $this->imageUrl,
            'importedAt' => $this->importedAt->format('dd/MM/yyyy H:i:s'),
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
