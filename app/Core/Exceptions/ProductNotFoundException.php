<?php

namespace App\Core\Exceptions;

use App\Core\Domain\Entities\Product;

class ProductNotFoundException extends EntityNotFoundException
{
    public function __construct()
    {
        parent::__construct(class_basename(Product::class));
    }
}
