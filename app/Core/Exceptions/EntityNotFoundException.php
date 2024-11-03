<?php

namespace App\Core\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct(string $classname)
    {
        parent::__construct("$classname not found.");
    }
}
