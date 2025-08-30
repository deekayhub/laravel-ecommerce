<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductsChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function handle(): void
    {
        $insertData = [];

        foreach ($this->rows as $record) {
            $insertData[] = [
                'name'        => $record['name'],
                'description' => $record['description'] ?? null,
                'price'       => (float) $record['price'],
                'image'       => $record['image'] ?? null,
                'category'    => $record['category'],
                'stock'       => (int)($record['stock'] ?? 0),
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        if (!empty($insertData)) {
            Product::insert($insertData);
            \Log::info("Inserted chunk of " . count($insertData) . " products.");
        }
    }
}
