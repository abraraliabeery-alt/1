<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends Controller
{
    const NAMES_PATH = 'products/names.txt';
    const PER_PAGE = 24;

    public function index(Request $request)
    {
        $page = max(1, (int)$request->query('page', 1));
        $names = $this->loadNames();
        if (empty($names)) {
            return view('products', [
                'items' => [],
                'total' => 0,
                'page' => $page,
                'paginator' => new LengthAwarePaginator([], 0, self::PER_PAGE, $page, ['path' => route('products.index')]),
                'notice' => 'لم يتم رفع ملف الأسماء بعد. الرجاء رفع ملف TXT أولاً.',
            ]);
        }

        // Show ALL without pagination regardless of source (requested behavior)
        $items = [];
        foreach ($names as $name) {
            $items[] = [
                'name' => $name,
                'image' => $this->getImageFor($name),
            ];
        }
        $total = count($items);
        // Single-page paginator stub to keep view helpers safe
        $paginator = new LengthAwarePaginator($items, $total, $total > 0 ? $total : 1, 1, ['path' => route('products.index')]);
        return view('products', compact('items', 'total', 'page', 'paginator'));
    }

    public function importForm()
    {
        return view('products_import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'names' => ['required', 'file', 'mimes:txt,csv,xlsx,xls', 'max:51200'],
            'column' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);
        $file = $request->file('names');
        $ext = strtolower($file->getClientOriginalExtension());

        // Parse into lines, then save normalized names.txt
        $names = $this->parseUploadedNames($file->getPathname(), $ext, (int) $request->input('column', 1));
        if (empty($names)) {
            return back()->withErrors(['names' => 'لم يتم العثور على أسماء صالحة في الملف.'])->withInput();
        }

        Storage::makeDirectory('products');
        $out = implode("\n", $names);
        Storage::put(self::NAMES_PATH, $out);

        return redirect()->route('products.index')->with('ok', 'تم استيراد '.count($names).' اسماً بنجاح.');
    }

    protected function loadNames(): array
    {
        try {
            // Prefer static config list if present
            $cfg = config('products.items');
            if (is_array($cfg) && !empty($cfg)) {
                // Accept either list of strings or list of arrays with name fields
                $names = [];
                foreach ($cfg as $row) {
                    if (is_string($row)) { $names[] = trim($row); continue; }
                    if (is_array($row)) {
                        $candidate = $row['name'] ?? ($row['name_ar'] ?? ($row['title'] ?? null));
                        if ($candidate) { $names[] = trim((string)$candidate); }
                    }
                }
                $names = array_values(array_filter($names, fn($v)=>$v!==''));
                return $names;
            }
            if (!Storage::exists(self::NAMES_PATH)) return [];
            $content = Storage::get(self::NAMES_PATH);
            $lines = preg_split("/\r\n|\r|\n/", $content);
            $names = array_values(array_filter(array_map('trim', $lines), fn($v) => $v !== '' && mb_strlen($v) <= 160));
            // Remove header if first line is a common header
            if ($names && in_array(mb_strtolower($names[0]), ['الاسم', 'name'])) {
                array_shift($names);
            }
            return $names;
        } catch (FileNotFoundException $e) {
            return [];
        }
    }

    /**
     * Parse uploaded names from TXT/CSV/XLSX files.
     */
    protected function parseUploadedNames(string $path, string $ext, int $column = 1): array
    {
        $colIndex = max(1, $column) - 1;
        $names = [];
        try {
            if (in_array($ext, ['txt'])) {
                $content = file_get_contents($path);
                $lines = preg_split("/\r\n|\r|\n/", (string)$content);
                $names = array_map('trim', $lines);
            } elseif (in_array($ext, ['csv'])) {
                if (($handle = fopen($path, 'r')) !== false) {
                    while (($row = fgetcsv($handle)) !== false) {
                        $val = trim((string)($row[$colIndex] ?? ''));
                        if ($val !== '') { $names[] = $val; }
                    }
                    fclose($handle);
                }
            } elseif (in_array($ext, ['xlsx','xls'])) {
                if (!class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
                    // Library not installed
                    return [];
                }
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($path);
                $sheet = $spreadsheet->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                for ($r = 1; $r <= $highestRow; $r++) {
                    $coord = $colLetter . $r;
                    $cell = $sheet->getCell($coord);
                    $val = trim((string)($cell ? $cell->getValue() : ''));
                    if ($val !== '') { $names[] = $val; }
                }
            }
        } catch (\Throwable $e) {
            $names = [];
        }

        // Normalize: remove header and dedupe/limit length
        $names = array_values(array_filter($names, fn($v) => $v !== ''));
        if ($names && in_array(mb_strtolower($names[0]), ['الاسم','name'])) {
            array_shift($names);
        }
        $names = array_map(function($v){ return mb_substr(trim($v), 0, 160); }, $names);
        $names = array_values(array_unique($names));
        return $names;
    }

    protected function getImageFor(string $query): string
    {
        $placeholder = '/assets/products/placeholder.svg';
        $apiKey = config('app.google_cse_key');
        $cx = config('app.google_cse_cx');
        if ($query === '') return $placeholder;

        // 1) Try precomputed map first
        try {
            if (\Illuminate\Support\Facades\Storage::exists('products/images.json')) {
                $json = json_decode(\Illuminate\Support\Facades\Storage::get('products/images.json'), true);
                if (is_array($json)) {
                    $k = mb_strtolower($query);
                    if (!empty($json[$k])) {
                        return (string)$json[$k];
                    }
                }
            }
        } catch (\Throwable $e) {}

        if (!$apiKey || !$cx) return $placeholder;

        $key = 'cse_img:' . md5(mb_strtolower($query));
        return Cache::remember($key, now()->addDays(30), function () use ($apiKey, $cx, $query, $placeholder) {
            try {
                $resp = Http::timeout(12)->get('https://www.googleapis.com/customsearch/v1', [
                    'key' => $apiKey,
                    'cx' => $cx,
                    'q' => $query,
                    'searchType' => 'image',
                    'num' => 1,
                    'safe' => 'active',
                    // 'lr' => 'lang_ar',
                ]);
                if (!$resp->successful()) return $placeholder;
                $json = $resp->json();
                $first = $json['items'][0]['link'] ?? null;
                return $first ?: $placeholder;
            } catch (\Throwable $e) {
                return $placeholder;
            }
        });
    }
}
