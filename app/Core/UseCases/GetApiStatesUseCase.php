<?php

namespace App\Core\UseCases;

use App\Core\Contracts\Repositories\ProductsImportRecordRepositoryInterface;
use App\Core\UseCases\DTO\ApiStatesOutputDTO;
use Illuminate\Support\Facades\DB;

class GetApiStatesUseCase
{
    public function __construct(private ProductsImportRecordRepositoryInterface $importerRepository) {}

    public function execute(): ApiStatesOutputDTO
    {
        $lastImportRun = $this->importerRepository->getLatestImportDateTime();
        $isDbConnected = $this->isDatabaseConnected();
        $memoryUsage = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);

        return new ApiStatesOutputDTO(
            lastImportRun: $lastImportRun ? $lastImportRun->format('d-M-yyyy H:m:i') : '-',
            memoryUsage: "{$memoryUsage} bytes",
            memoryPeak: "{$memoryPeak} bytes",
            dbConnectionStatus: $isDbConnected,
        );
    }

    private function isDatabaseConnected(): string
    {
        try {
            DB::connection()->getPdo();
            return "OK";
        } catch (\Throwable $th) {
            return "Not connected";
        }
    }
}
