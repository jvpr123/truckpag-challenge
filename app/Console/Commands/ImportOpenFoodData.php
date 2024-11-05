<?php

namespace App\Console\Commands;

use App\Core\Contracts\Repositories\ProductRepositoryInterface;
use App\Core\Contracts\Repositories\ProductsImportRecordRepositoryInterface;
use App\Core\Domain\Entities\Product;
use App\Core\Domain\Enums\ProductStatus;
use App\Infrainstructure\Transformers\ProductTransformer;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportOpenFoodData extends Command
{
    protected $signature = 'import:open-food-data';

    protected $description = 'Import most recent Open-Food data to local database.';

    protected string $importBaseUrl = 'https://challenges.coode.sh/food/data/json';

    public function __construct(
        private ProductTransformer $productTransformer,
        private ProductsImportRecordRepositoryInterface $importsRepository,
        private ProductRepositoryInterface $productRepository,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $fileListResponse = Http::get("{$this->importBaseUrl}/index.txt");

        if (!$fileListResponse->successful()) {
            $this->error(">>> Failed to retrieve import files list.");
            return Command::FAILURE;
        }

        $files = array_filter(preg_split('/\r\n|\r|\n/', $fileListResponse->body()));
        if (empty($files)) {
            $this->error(">>> No files available for import.");
            return Command::FAILURE;
        }

        $file = $this->getImportFileUrl($files);
        if (!$file) {
            $this->error('>>> No import file available.');
            return Command::FAILURE;
        }

        $this->info(">>> Downloading and processing file...");

        try {
            $fileUrl = "{$this->importBaseUrl}/{$file}";
            $productsToSave = $this->processImportFile($fileUrl);
            $this->productRepository->createMany($productsToSave);
        } catch (Exception $e) {
            $this->importsRepository->registerImportFileRecord(filename: $file, success: false);
            $this->error(">>> Failed to process the file: {$e->getMessage()}");
            return Command::FAILURE;
        }

        $this->importsRepository->registerImportFileRecord(filename: $file, success: true);
        $this->info('>>> Products import completed.');
        return Command::SUCCESS;
    }

    private function getImportFileUrl(array $files): ?string
    {
        foreach ($files as $file) {
            $isImported = $this->importsRepository->isFileAlreadyImported($file);
            if (!$isImported) {
                return $file;
            }
        }

        return null;
    }

    private function processImportFile(string $fileUrl): array
    {
        $response = Http::withOptions(['stream' => true])->get($fileUrl);

        if ($response->successful()) {
            $tempFilePath = tempnam(sys_get_temp_dir(), 'json_gz_');
            file_put_contents($tempFilePath, $response->body());

            $gz = gzopen($tempFilePath, 'rb');

            if ($gz === false) {
                $this->error('>>> Could not open gzipped file.');
            }

            $linesRead = 0;
            $productsToSave = collect();

            while (($line = gzgets($gz)) !== false && $linesRead < 100) {
                $jsonData = json_decode($line, true);

                if ($jsonData !== null) {
                    $product = new Product(
                        id: null,
                        code: $jsonData['code'],
                        status: ProductStatus::PUBLISHED,
                        url: $jsonData['url'],
                        creator: $jsonData['creator'],
                        productName: $jsonData['product_name'],
                        quantity: (int) $jsonData['quantity'],
                        brands: $jsonData['brands'],
                        categories: $jsonData['categories'],
                        labels: $jsonData['labels'],
                        cities: $jsonData['cities'],
                        purchasePlaces: $jsonData['purchase_places'],
                        stores: $jsonData['stores'],
                        ingredientsText: $jsonData['ingredients_text'],
                        traces: $jsonData['traces'],
                        servingSize: $jsonData['serving_size'],
                        serving_quantity: $jsonData['serving_quantity'],
                        nutriscoreScore: $jsonData['nutriscore_score'],
                        nutriscoreGrade: $jsonData['nutriscore_grade'],
                        mainCategory: $jsonData['main_category'],
                        imageUrl: $jsonData['image_url'],
                        importedAt: now(),
                        createdAt: time(),
                        updatedAt: time(),
                    );

                    $productsToSave->push($this->productTransformer->entityToModel($product)->toArray());
                    $linesRead++;
                } else {
                    echo "Invalid JSON line: $line" . PHP_EOL;
                }
            }

            gzclose($gz);
            unlink($tempFilePath);
        } else {
            $this->error('Failed to download the file.');
        }

        return $productsToSave->toArray();
    }
}
