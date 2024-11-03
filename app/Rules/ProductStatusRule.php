<?php

namespace App\Rules;

use App\Core\Domain\Enums\ProductStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductStatusRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedProductStatus = [
            ProductStatus::PUBLISHED->value,
            ProductStatus::DRAFT->value,
        ];

        if (!in_array($value, $allowedProductStatus)) {
            $options = implode(', ', $allowedProductStatus);
            $fail("The {$attribute} must be a valid option: {$options}.");
        }
    }
}
