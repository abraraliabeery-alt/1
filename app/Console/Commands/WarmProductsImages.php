<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WarmProductsImages extends Command
{
    protected $signature = 'products:warm-images {--limit=0 : Max items to process} {--offset=0 : Start index offset} {--sleep=300 : Microseconds sleep between calls}';
    protected $description = 'Pre-fetch image URLs for all products and store to storage/products/images.json';

    public function handle(): int
    {
        $apiKey = config('app.google_cse_key');
        $cx = config('app.google_cse_cx');
        if (!$apiKey || !$cx) {
            $this->error('Missing GOOGLE_CSE_KEY or GOOGLE_CSE_CX');
            return self::FAILURE;
        }

        // Load names
        $names = $this->loadNames();
        if (empty($names)) {
            $this->error('No product names found. Fill config/products.php or upload names.');
            return self::FAILURE;
        }

        // Load existing map
        $map = [];
        if (Storage::exists('products/images.json')) {
            $json = json_decode(Storage::get('products/images.json'), true);
            if (is_array($json)) { $map = $json; }
        }

        $limit = max(0, (int)$this->option('limit'));
        $offset = max(0, (int)$this->option('offset'));
        $sleep = max(0, (int)$this->option('sleep'));

        $total = count($names);
        $end = $limit > 0 ? min($total, $offset + $limit) : $total;

        $processed = 0;
        for ($i = $offset; $i < $end; $i++) {
            $name = $names[$i];
            $key = mb_strtolower($name);
            if (!empty($map[$key])) { continue; }

            $url = $this->fetchImage($name, $apiKey, $cx);
            if ($url) {
                $map[$key] = $url;
                $processed++;
            }

            if ($sleep > 0) { usleep($sleep); }

            // Persist every 50 writes for safety
            if ($processed % 50 === 0) {
                $this->persist($map);
                $this->info("Progress: {$i}/{$total} (saved)");
            }
        }

        $this->persist($map);
        $this->info('Done. Images mapped: '.count($map));
        return self::SUCCESS;
    }

    protected function loadNames(): array
    {
        $cfg = config('products.items');
        if (is_array($cfg) && !empty($cfg)) {
            $names = [];
            foreach ($cfg as $row) {
                if (is_string($row)) { $names[] = trim($row); }
                elseif (is_array($row)) {
                    $candidate = $row['name'] ?? ($row['name_ar'] ?? ($row['title'] ?? null));
                    if ($candidate) { $names[] = trim((string)$candidate); }
                }
            }
            return array_values(array_filter($names, fn($v)=>$v!==''));
        }
        if (Storage::exists('products/names.txt')) {
            $lines = preg_split("/\r\n|\r|\n/", Storage::get('products/names.txt'));
            return array_values(array_filter(array_map('trim', $lines), fn($v)=>$v!==''));
        }
        return [];
    }

    protected function fetchImage(string $query, string $apiKey, string $cx): ?string
    {
        try {
            $resp = Http::timeout(12)->get('https://www.googleapis.com/customsearch/v1', [
                'key' => $apiKey,
                'cx' => $cx,
                'q' => $query,
                'searchType' => 'image',
                'num' => 1,
                'safe' => 'active',
            ]);
            if (!$resp->successful()) return null;
            $json = $resp->json();
            return $json['items'][0]['link'] ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function persist(array $map): void
    {
        Storage::makeDirectory('products');
        Storage::put('products/images.json', json_encode($map, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
    }
}
