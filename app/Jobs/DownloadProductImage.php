<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DownloadProductImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $sku;
    protected string $imageUrl;

    public function __construct(string $sku, string $imageUrl)
    {
        $this->sku = $sku;
        $this->imageUrl = $imageUrl;
    }

    public function handle(): void
    {
        try {
            $response = Http::timeout(20)->get($this->imageUrl);

            if ($response->successful()) {
                $extension = pathinfo(parse_url($this->imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                $extension = $extension ?: 'jpg';
                $filename = Str::uuid() . '.' . $extension;

                Storage::disk('public')->put('products/' . $filename, $response->body());

                $imagePath = 'products/' . $filename;

                Product::where('sku', $this->sku)->update(['image' => $imagePath]);

                \Log::info("Image saved for SKU {$this->sku}: {$imagePath}");
            } else {
                \Log::warning("Image download failed for SKU {$this->sku} from URL: {$this->imageUrl}");
            }
        } catch (\Exception $e) {
            \Log::error("Image download error for SKU {$this->sku}: " . $e->getMessage());
        }
    }
}
