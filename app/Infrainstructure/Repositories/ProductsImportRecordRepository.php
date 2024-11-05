<?php

namespace App\Infrainstructure\Repositories;

use App\Core\Contracts\Repositories\ProductsImportRecordRepositoryInterface;
use App\Models\ProductsImportRecord;

class ProductsImportRecordRepository implements ProductsImportRecordRepositoryInterface
{
    public function isFileAlreadyImported(string $filename): bool
    {
        return ProductsImportRecord::where('imported_file', $filename)
            ->where('success', true)
            ->exists();
    }

    public function registerImportFileRecord(string $filename, bool $success): void
    {
        $record = new ProductsImportRecord();
        $record->fill(['imported_file' => $filename, 'success' => $success]);
        $record->saveOrFail();
    }
}
