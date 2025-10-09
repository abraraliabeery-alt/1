<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->check(), 403);
        $favs = Favorite::with(['property' => function($q){
            $q->latest();
        }])->where('user_id', auth()->id())
          ->latest()->paginate(12);
        return view('favorites.index', compact('favs'));
    }

    public function toggle(Property $property)
    {
        abort_unless(auth()->check(), 403);
        $exists = Favorite::where('user_id', auth()->id())
            ->where('property_id', $property->id)
            ->first();
        if ($exists) {
            $exists->delete();
            return back()->with('ok', 'تمت إزالة العقار من المفضلة');
        }
        Favorite::create([
            'user_id' => auth()->id(),
            'property_id' => $property->id,
        ]);
        return back()->with('ok', 'تم إضافة العقار إلى المفضلة');
    }
}
