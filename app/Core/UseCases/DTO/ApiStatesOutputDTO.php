<?php

namespace App\Core\UseCases\DTO;

class ApiStatesOutputDTO
{
    public function __construct(
        public string $lastImportRun,
        public string $memoryUsage,
        public string $memoryPeak,
        public string $dbConnectionStatus,
    ) {}
}
