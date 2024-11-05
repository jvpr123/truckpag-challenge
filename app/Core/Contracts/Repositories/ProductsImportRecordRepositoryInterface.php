<?php

namespace App\Core\Contracts\Repositories;

interface ProductsImportRecordRepositoryInterface
{
    public function isFileAlreadyImported(string $filename): bool;
}
