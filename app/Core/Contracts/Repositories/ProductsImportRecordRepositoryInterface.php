<?php

namespace App\Core\Contracts\Repositories;

use DateTime;

interface ProductsImportRecordRepositoryInterface
{
    public function getLatestImportDateTime(): ?DateTime;

    public function isFileAlreadyImported(string $filename): bool;

    public function registerImportFileRecord(string $filename, bool $success): void;
}
