<?php

use App\Core\Domain\Entities\Product;

class ProductNotFoundException extends EntityNotFoundException
{
    public function __construct()
    {
        $classname = class_basename(Product::class);
        parent::__construct("$classname not found.");
    }
}
