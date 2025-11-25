<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $page  = max(1, (int) $request->query('page', 1));
        $perPage = 10; // Google CSE default limit per page
        $start = (($page - 1) * $perPage) + 1; // 1-indexed
        if ($start > 90) { // Google allows start up to 91 for 10 results/page
            $start = 91;
        }

        $apiKey = config('app.google_cse_key');
        $cx     = config('app.google_cse_cx');

        $error = null;
        $results = [
            'items' => [],
            'searchInformation' => null,
            'queries' => [],
        ];

        if ($query !== '' && $apiKey && $cx) {
            try {
                $response = Http::timeout(10)->get('https://www.googleapis.com/customsearch/v1', [
                    'key'  => $apiKey,
                    'cx'   => $cx,
                    'q'    => $query,
                    'num'  => $perPage,
                    'start'=> $start,
                    // Optional tuning
                    // 'safe' => 'active',
                    // 'lr'   => 'lang_ar',
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $results['items'] = $json['items'] ?? [];
                    $results['searchInformation'] = $json['searchInformation'] ?? null;
                    $results['queries'] = $json['queries'] ?? [];
                } else {
                    $error = 'Search request failed: HTTP '.$response->status();
                }
            } catch (\Throwable $e) {
                $error = 'Search error: '.$e->getMessage();
            }
        } elseif ($query !== '' && (!$apiKey || !$cx)) {
            $error = 'Missing Google CSE credentials. Please configure GOOGLE_CSE_KEY and GOOGLE_CSE_CX.';
        }

        // Determine pagination availability
        $nextPage = null;
        $prevPage = null;
        if ($query !== '') {
            $prevPage = $page > 1 ? $page - 1 : null;
            // If API returned nextPage info use it; otherwise assume there may be next unless start is near cap
            if (!empty($results['queries']['nextPage'][0]['startIndex'])) {
                $nextPage = $page + 1;
            } elseif ($start < 91 && count($results['items']) === $perPage) {
                $nextPage = $page + 1;
            }
        }

        return view('search', [
            'q' => $query,
            'page' => $page,
            'items' => $results['items'],
            'info' => $results['searchInformation'],
            'error' => $error,
            'nextPage' => $nextPage,
            'prevPage' => $prevPage,
        ]);
    }

    public function showImagesBatch()
    {
        return view('images-batch');
    }

    public function handleImagesBatch(Request $request)
    {
        $request->validate([
            'names' => ['required', 'file', 'mimes:txt', 'max:10240'],
            'num' => ['nullable', 'integer', 'min:1', 'max:3'],
        ]);

        $apiKey = config('app.google_cse_key');
        $cx     = config('app.google_cse_cx');
        if (!$apiKey || !$cx) {
            return back()->withErrors(['names' => 'Missing Google CSE credentials.'])->withInput();
        }

        $num = (int) ($request->input('num', 1));
        $content = file_get_contents($request->file('names')->getRealPath());
        $lines = preg_split("/\r\n|\r|\n/", $content);
        $names = array_values(array_filter(array_map('trim', $lines), fn($v) => $v !== ''));

        $results = [];
        foreach ($names as $name) {
            $images = $this->fetchImages($name, $num);
            $results[] = [
                'name' => $name,
                'images' => $images,
            ];
        }

        return view('images-batch', [
            'results' => $results,
            'num' => $num,
        ]);
    }

    protected function fetchImages(string $query, int $num = 1): array
    {
        $apiKey = config('app.google_cse_key');
        $cx     = config('app.google_cse_cx');
        if (!$apiKey || !$cx || $query === '') {
            return [];
        }
        try {
            $response = Http::timeout(12)->get('https://www.googleapis.com/customsearch/v1', [
                'key' => $apiKey,
                'cx' => $cx,
                'q' => $query,
                'searchType' => 'image',
                'num' => min(3, max(1, $num)),
                'safe' => 'active',
                // 'lr' => 'lang_ar',
            ]);
            if (!$response->successful()) {
                return [];
            }
            $json = $response->json();
            $items = $json['items'] ?? [];
            $out = [];
            foreach ($items as $it) {
                $out[] = [
                    'title' => $it['title'] ?? null,
                    'link' => $it['link'] ?? null,
                    'mime' => $it['mime'] ?? null,
                    'thumbnail' => $it['image']['thumbnailLink'] ?? null,
                    'contextLink' => $it['image']['contextLink'] ?? null,
                ];
            }
            return $out;
        } catch (\Throwable $e) {
            return [];
        }
    }
}
