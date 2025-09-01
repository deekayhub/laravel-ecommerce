<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ProcessProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected int $chunkSize = 1000; // rows per job

    public function __construct(string $filePath, int $chunkSize = 1000)
    {
        $this->filePath  = $filePath;
        $this->chunkSize = $chunkSize;
    }

    public function handle(): void
    {
        if (!Storage::exists($this->filePath)) {
            \Log::error("Import file not found: " . $this->filePath);
            return;
        }

        $fullPath  = Storage::path($this->filePath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        try {
            if ($extension === 'csv') {
                $this->chunkCSV($fullPath);
            } else {
                $this->chunkExcel($fullPath);
            }

            // Delete file after dispatching all jobs
            Storage::delete($this->filePath);

        } catch (\Throwable $e) {
            \Log::error("Product import error: " . $e->getMessage(), [
                'file' => $this->filePath,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    protected function chunkCSV(string $fullPath): void
    {
        \Log::info("CSV chunking started for file: " . $this->filePath);

        $csv = Reader::createFromPath($fullPath, 'r');
        $csv->setHeaderOffset(0);
        $records = iterator_to_array($csv->getRecords());

        $chunk = [];
        $processed = 0;

        foreach ($records as $record) {
            if (empty($record['sku']) || empty($record['name']) || empty($record['price']) || empty($record['category'])) {
                continue;
            }


            $chunk[] = $record;
            $processed++;

            // Dispatch chunk when size is reached
            if (count($chunk) === $this->chunkSize) {
                ImportProductsChunk::dispatch($chunk);
                $chunk = []; // Reset chunk
            }
        }

        // Leftover rows
        if (!empty($chunk)) {
            ImportProductsChunk::dispatch($chunk);
        }

        \Log::info("CSV chunking completed for file: " . $this->filePath . ". Processed $processed records.");
    }

    protected function chunkExcel(string $fullPath): void
    {

        \Log::info("Excel chunking would happen here for file: " . $this->filePath);
    }
}
