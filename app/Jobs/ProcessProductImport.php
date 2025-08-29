<?php

namespace App\Jobs;

use App\Models\Product;
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

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        if (!Storage::exists($this->filePath)) {
            \Log::error("Import file not found: " . $this->filePath);
            return;
        }

        $fullPath = Storage::path($this->filePath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        try {
            if ($extension === 'csv') {
                $this->processCSV($fullPath);
            } else {
                $this->processExcel($fullPath);
            }

            // Clean up file after processing
            Storage::delete($this->filePath);

        } catch (\Exception $e) {
            \Log::error("Product import error: " . $e->getMessage());
        }
    }

    protected function processCSV($filePath)
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $batchSize = 1000;
        $batch = [];

        foreach ($records as $offset => $record) {
            // Validate required fields
            if (empty($record['name']) || empty($record['price']) || empty($record['category'])) {
                continue;
            }

            $batch[] = [
                'name' => $record['name'],
                'description' => $record['description'] ?? null,
                'price' => (float) $record['price'],
                'image' => $record['image'] ?? null,
                'category' => $record['category'],
                'stock' => (int) ($record['stock'] ?? 0),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= $batchSize) {
                Product::insert($batch);
                $batch = [];
            }
        }

        // Insert remaining records
        if (!empty($batch)) {
            Product::insert($batch);
        }
    }

    protected function processExcel($filePath)
    {
        // For Excel processing, you would need to install maatwebsite/excel package
        // This is a placeholder implementation
        \Log::info("Excel processing would happen here for file: " . $filePath);
    }
}