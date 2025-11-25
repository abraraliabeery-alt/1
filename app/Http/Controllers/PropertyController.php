<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $q = Property::query();

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
        if ($request->filled('type')) {
            $q->where('type', $request->string('type'));
        }
        if ($request->filled('min_price')) {
            $q->where('price', '>=', (int)$request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $q->where('price', '<=', (int)$request->input('max_price'));
        }
        if ($request->filled('bedrooms')) {
            $q->where('bedrooms', '>=', (int)$request->input('bedrooms'));
        }
        if ($request->filled('bathrooms')) {
            $q->where('bathrooms', '>=', (int)$request->input('bathrooms'));
        }
        if ($request->boolean('featured')) {
            $q->where('is_featured', true);
        }

        $properties = $q->latest('id')->paginate(12)->appends($request->query());

        $cities = Property::query()->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $types  = Property::query()->select('type')->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');
        $featured = Property::query()->where('is_featured', true)->latest('id')->take(8)->get();

        return view('properties.index', compact('properties','cities','types','featured'));
    }

    public function show(Property $property)
    {
        $similar = $property->similar(6);

        return view('properties.show', compact('property', 'similar'));
    }
}

