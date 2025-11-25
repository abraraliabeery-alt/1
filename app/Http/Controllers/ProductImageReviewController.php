<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductImageReviewController extends Controller
{
    public function index(Request $request)
    {
        $limit = (int)$request->query('limit', 200);
        $mode  = (string)$request->query('mode', 'all'); // all | missing
        $all   = collect(config('products.items', []));
        $items = $all;
        if ($mode === 'missing') {
            $items = $all->filter(function ($p) {
                $img = trim((string)($p['image'] ?? ''));
                if ($img === '') return true;
                return \Illuminate\Support\Str::endsWith($img, '/assets/products/placeholder.svg');
            });
        }
        $items = $items->take($limit)->values();
        return view('admin.products_images_review', [
            'items' => $items,
            'limit' => $limit,
            'mode'  => $mode,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'images' => 'array',
            'images.*.key' => 'nullable|string',
            'images.*.url' => 'nullable|string',
        ]);
        $linkOnly = (bool)$request->input('link_only', false);
        $pairs = $data['images'] ?? [];
        if (!$pairs) { return back()->with('status', 'لا توجد روابط مضافة'); }

        $items = config('products.items', []);
        $imgDir = public_path('assets/products');
        if (!is_dir($imgDir)) @mkdir($imgDir, 0775, true);

        $updated = 0;
        foreach ($pairs as $pair) {
            $url = trim($pair['url'] ?? '');
            $key = trim($pair['key'] ?? '');
            if (!$url) continue;

            // find product index by sku or name slug
            $index = null;
            foreach ($items as $i => $p) {
                $sku = $p['sku'] ?? '';
                $name = $p['name_ar'] ?? '';
                $slug = Str::slug(mb_substr($name, 0, 60));
                if ($key && ($key === (string)$sku || $key === $slug)) { $index = $i; break; }
                if (!$key && $name === ($pair['name'] ?? '')) { $index = $i; break; }
            }
            if ($index === null) continue;

            if ($linkOnly) {
                $items[$index]['image'] = $url;
                $updated++;
            } else {
                $file = $this->download($url, $imgDir, ($items[$index]['sku'] ?? '') ?: Str::slug(mb_substr($items[$index]['name_ar'] ?? 'prod',0,60)));
                if ($file) {
                    $items[$index]['image'] = '/assets/products/'.$file;
                    $updated++;
                }
            }
        }

        // write back config
        $out = base_path('config/products.php');
        $php = "<?php\nreturn ".var_export(['items'=>$items], true).";\n";
        file_put_contents($out, $php);

        return back()->with('status', 'تم تحديث الصور: '.$updated);
    }

    private function download(string $url, string $dir, string $base): ?string
    {
        try {
            $ext = pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg';
            $ext = strtolower($ext);
            if (!in_array($ext, ['jpg','jpeg','png','webp'])) { $ext = 'jpg'; }
            $name = Str::slug($base) . '.' . $ext;
            $dest = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;
            $ctx = stream_context_create(['http'=>['timeout'=>12],'https'=>['timeout'=>12]]);
            $data = @file_get_contents($url, false, $ctx);
            if ($data === false) return null;
            file_put_contents($dest, $data);
            return $name;
        } catch (\Throwable $e) { return null; }
    }
}
