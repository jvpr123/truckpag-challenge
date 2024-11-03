<?php

namespace App\Core\Exceptions;

use App\Core\Domain\Enums\ProductStatus;
use Exception;

class InvalidProductStatusException extends Exception
{
    const VALID_PRODUCT_STATUS = [
        ProductStatus::PUBLISHED->value,
        ProductStatus::DRAFT->value,
        ProductStatus::TRASH->value,
    ];

    public function __construct()
    {
        $validOptions = implode(', ', self::VALID_PRODUCT_STATUS);
        parent::__construct("Product status must be a valid option:{ $validOptions}.");
    }
}
