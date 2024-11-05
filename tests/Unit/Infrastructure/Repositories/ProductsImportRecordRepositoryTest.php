<?php

namespace Tests\Unit\Infrastructure\Repositories;

use App\Infrainstructure\Repositories\ProductsImportRecordRepository;
use App\Models\ProductsImportRecord;

describe('ProductsImportRecordRepository -> isFileAlreadyImported()', function () {
    beforeEach(fn() => $this->repository = new ProductsImportRecordRepository());

    it('should return TRUE if file provided was already imported', function () {
        $record = ProductsImportRecord::factory()->create(['success' => true]);

        $output = $this->repository->isFileAlreadyImported($record->imported_file);
        expect($output)->toBeTrue();
    });

    it('should return FALSE if file provided wasn`t already imported', function () {
        $output = $this->repository->isFileAlreadyImported('filename');
        expect($output)->toBeFalse();
    });
});
