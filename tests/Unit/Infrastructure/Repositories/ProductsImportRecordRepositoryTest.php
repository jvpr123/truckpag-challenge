<?php

namespace Tests\Unit\Infrastructure\Repositories;

use App\Infrainstructure\Repositories\ProductsImportRecordRepository;
use App\Models\ProductsImportRecord;
use Exception;

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

describe('ProductsImportRecordRepository -> registerImportFileRecord()', function () {
    beforeEach(fn() => $this->repository = new ProductsImportRecordRepository());

    it('should register a products import file record successfully', function () {
        $this->repository->registerImportFileRecord(
            $filename = fake()->filePath(),
            $success = fake()->boolean(),
        );

        $this->assertDatabaseHas('products_import_records', [
            'imported_file' => $filename,
            'success' => $success,
        ]);
    });

    it('should throw an exception on saving record error', function () {
        ProductsImportRecord::saving(fn() => throw new Exception('Error saving record.'));

        $this->repository->registerImportFileRecord(
            filename: fake()->filePath(),
            success: fake()->boolean(),
        );
    })->throws(Exception::class, 'Error saving record.');
});
