<?php

namespace App\Jobs;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadGalleryImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $item;
    protected $url;

    public function __construct(Item $item, string $url)
    {
        $this->item = $item;
        $this->url  = $url;
    }

    public function handle()
    {
        try {
            $contents = Http::timeout(20)->get($this->url)->body();
            $filename = 'items/gallery/' . basename(parse_url($this->url, PHP_URL_PATH));
            Storage::disk('public')->put($filename, $contents);

            $this->item->gallery()->create([
                'gallery'         => 'storage/' . $filename,
                'display_gallery' => 1,
            ]);
        } catch (\Exception $e) {
            // log error if needed
        }
    }
}
