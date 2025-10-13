<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    // Public
    public function index(Request $request)
    {
        $items = GalleryItem::query()
            ->orderBy('sort_order')
            ->latest()
            ->paginate(24);
        return view('gallery.index', compact('items'));
    }

    public function show(string $slug)
    {
        $item = GalleryItem::where('slug', $slug)->firstOrFail();
        return view('gallery.show', compact('item'));
    }

    // Staff
    public function create()
    {
        $items = GalleryItem::orderBy('sort_order')->latest()->get();
        return view('admin.gallery.sort', compact('items'));
    }

    public function store(Request $request)
    {
        // Accept single or multiple images
        $request->validate([
            'image' => ['nullable','image'],
            'images' => ['nullable','array'],
            'images.*' => ['image'],
        ]);

        $files = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
        } elseif ($request->hasFile('image')) {
            $files = [$request->file('image')];
        }
        if (!$files) {
            return back()->withErrors(['image' => 'الرجاء اختيار صورة واحدة على الأقل'])->withInput();
        }

        $dir = public_path('uploads/gallery');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }

        $created = [];
        foreach ($files as $file) {
            $name = 'g_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $imgPath = '/uploads/gallery/'.$name;

            $title = 'صورة';
            $slug = Str::slug($title.'-'.Str::random(6));

            $created[] = GalleryItem::create([
                'title' => $title,
                'slug' => $slug,
                'image_path' => $imgPath,
                'sort_order' => 0,
                'is_featured' => false,
            ]);
        }

        if (count($created) === 1) {
            return redirect()->route('gallery.show', $created[0]->slug)->with('ok', 'تمت إضافة الصورة');
        }
        return redirect()->route('gallery.index')->with('ok', 'تمت إضافة '.count($created).' صور');
    }

    public function edit(GalleryItem $item)
    {
        return view('gallery.edit', compact('item'));
    }

    public function update(Request $request, GalleryItem $item)
    {
        $data = $request->validate([
            'title' => ['required','string','max:190'],
            'caption' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:120'],
            'city' => ['nullable','string','max:120'],
            'taken_at' => ['nullable','date'],
            'is_featured' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0','max:999999'],
            'image' => ['nullable','image'],
        ]);
        $item->fill([
            'title' => $data['title'],
            'caption' => $data['caption'] ?? null,
            'category' => $data['category'] ?? null,
            'city' => $data['city'] ?? null,
            'taken_at' => $data['taken_at'] ?? null,
            'is_featured' => (bool)($data['is_featured'] ?? false),
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ]);
        if ($request->hasFile('image')) {
            $dir = public_path('uploads/gallery'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = 'g_'.time().'_'.Str::random(6).'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($dir, $name);
            $item->image_path = '/uploads/gallery/'.$name;
        }
        $item->save();
        return redirect()->route('gallery.show', $item->slug)->with('ok', 'تم تحديث الصورة');
    }

    public function destroy(GalleryItem $item)
    {
        $item->delete();
        return redirect()->route('gallery.index')->with('ok', 'تم حذف الصورة');
    }

    // Sorting (staff)
    public function sort()
    {
        $items = GalleryItem::orderBy('sort_order')->latest()->get();
        return view('admin.gallery.sort', compact('items'));
    }

    public function sortSave(Request $request)
    {
        $data = $request->validate([
            'orders' => ['required','array'],
            'orders.*' => ['integer'],
        ]);
        foreach ($data['orders'] as $id => $order) {
            GalleryItem::where('id', (int)$id)->update(['sort_order' => (int)$order]);
        }
        return redirect()->route('gallery.index')->with('ok', 'تم حفظ ترتيب الصور');
    }
}
