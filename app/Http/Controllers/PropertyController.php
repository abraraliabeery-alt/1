<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    private function themedView(string $name): string
    {
        $theme = config('app.theme', 'theme1');

        $view = "themes.{$theme}.properties.{$name}";
        if (view()->exists($view)) {
            return $view;
        }

        $fallback = "themes.theme1.properties.{$name}";
        if (view()->exists($fallback)) {
            return $fallback;
        }

        return "properties.{$name}";
    }

    public function lands(Request $request)
    {
        // Force lands-only filter (reliable for GET requests)
        $request->query->set('type', 'land');
        $request->request->set('type', 'land');
        $request->merge(['type' => 'land']);
        return $this->index($request);
    }

    public function index(Request $request)
    {
        $q = Property::query();

        if ($request->routeIs('lands.index')) {
            $q->where(function ($w) {
                $w->whereIn('type', ['land', 'lands', 'أرض', 'ارض'])
                  ->orWhereRaw("LOWER(TRIM(type)) IN ('land','lands')")
                  ->orWhereRaw("TRIM(type) IN ('أرض','ارض')");
            });
        }

        if ($request->filled('q')) {
            $term = trim($request->string('q'));
            $q->where(function($w) use ($term){
                $w->where('title', 'like', "%{$term}%")
                  ->orWhere('city', 'like', "%{$term}%")
                  ->orWhere('district', 'like', "%{$term}%");
            });
        }
        if ($request->filled('city')) {
            $q->where('city', $request->string('city'));
        }
        if ($request->filled('district')) {
            $q->where('district', $request->string('district'));
        }
        if (!$request->routeIs('lands.index') && $request->filled('type')) {
            $rawType = trim((string) $request->input('type'));
            $type = mb_strtolower($rawType);

            // Normalize common variants so /lands always returns lands only
            if (in_array($type, ['land', 'lands', 'أرض', 'ارض'], true)) {
                $q->where(function ($w) {
                    $w->whereIn('type', ['land', 'lands', 'أرض', 'ارض'])
                      ->orWhereRaw("LOWER(TRIM(type)) IN ('land','lands')")
                      ->orWhereRaw("TRIM(type) IN ('أرض','ارض')");
                });
            } else {
                $q->where('type', $rawType);
            }
        }
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }
        if ($request->filled('min_price')) {
            $q->where('price', '>=', (int)$request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $q->where('price', '<=', (int)$request->input('max_price'));
        }
        if ($request->filled('min_area')) {
            $q->where('area', '>=', (int)$request->input('min_area'));
        }
        if ($request->filled('max_area')) {
            $q->where('area', '<=', (int)$request->input('max_area'));
        }

        $sort = (string) $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $q->orderBy('price', 'asc')->orderBy('id', 'desc');
                break;
            case 'price_desc':
                $q->orderBy('price', 'desc')->orderBy('id', 'desc');
                break;
            case 'area_asc':
                $q->orderBy('area', 'asc')->orderBy('id', 'desc');
                break;
            case 'area_desc':
                $q->orderBy('area', 'desc')->orderBy('id', 'desc');
                break;
            default:
                $q->latest('id');
                break;
        }

        $properties = $q->paginate(12)->appends($request->query());

        $cities = Property::query()->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $districts = Property::query()
            ->select('district')
            ->whereNotNull('district')
            ->when($request->filled('city'), fn($qq) => $qq->where('city', $request->string('city')))
            ->distinct()
            ->orderBy('district')
            ->pluck('district');
        $types  = Property::query()->select('type')->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');
        $statuses = Property::query()->select('status')->whereNotNull('status')->distinct()->orderBy('status')->pluck('status');
        $featured = Property::query()->where('is_featured', true)->latest('id')->take(8)->get();

        $minPrice = (int) (Property::query()->min('price') ?? 0);
        $maxPrice = (int) (Property::query()->max('price') ?? 0);
        $minArea  = (int) (Property::query()->whereNotNull('area')->min('area') ?? 0);
        $maxArea  = (int) (Property::query()->whereNotNull('area')->max('area') ?? 0);

        return view($this->themedView('index'), compact('properties','cities','districts','types','statuses','featured','minPrice','maxPrice','minArea','maxArea'));
    }

    public function show(Property $property)
    {
        $similar = $property->similar(6);

        return view($this->themedView('show'), compact('property', 'similar'));
    }
}

