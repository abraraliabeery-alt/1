<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Project;
use App\Models\GalleryItem;
use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function landing()
    {
        // For the company site, surface featured projects on the landing page
        $projects = Project::query()
            ->orderByDesc('is_featured')
            ->latest()
            ->limit(6)
            ->get();
        $gallery = GalleryItem::query()->orderBy('sort_order')->latest()->limit(6)->get();
        $events = Event::query()->orderByDesc('is_featured')
            ->orderBy('starts_at')
            ->latest()
            ->limit(6)
            ->get();
        return view('landing', compact('projects','gallery','events'));
    }

    public function home(Request $request)
    {
        $properties = Property::query()
            ->orderByDesc('is_featured')
            ->orderBy('price')
            ->limit(6)->get();
        return view('home', compact('properties'));
    }

    public function index(Request $request)
    {
        $query = Property::query();
        $query->when($request->filled('city'), fn($q) => $q->where('city', 'like', "%{$request->city}%"));
        $query->when($request->filled('type'), fn($q) => $q->where('type', $request->type));
        $query->when($request->filled('min'), fn($q) => $q->where('price', '>=', (int)$request->min));
        $query->when($request->filled('max'), fn($q) => $q->where('price', '<=', (int)$request->max));
        $query->when($request->filled('beds'), fn($q) => $q->where('bedrooms', '>=', (int)$request->beds));
        $properties = $query->orderByDesc('is_featured')->orderBy('price')->paginate(9)->withQueryString();
        return view('properties.index', compact('properties'));
    }

    public function show(string $slug)
    {
        $property = Property::where('slug', $slug)->with(['comments' => function($q){
            $q->latest();
        }, 'comments.user'])->firstOrFail();
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = Favorite::where('user_id', auth()->id())
                ->where('property_id', $property->id)
                ->exists();
        }
        // Compute embed URL for YouTube if provided
        $embedUrl = null;
        if (!empty($property->video_url)) {
            $embedUrl = $property->video_url;
            if (str_contains($embedUrl, 'watch?v=')) {
                $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
            }
            if (str_starts_with($embedUrl, 'https://youtu.be/')) {
                $embedUrl = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $embedUrl);
            }
        }
        // Build media slides (all) and separate image slides
        $mediaSlides = [];
        $imageSlides = [];
        if (!empty($property->video_path)) {
            $mediaSlides[] = ['type' => 'video', 'src' => $property->video_path, 'alt' => $property->title];
        } elseif (!empty($embedUrl)) {
            $mediaSlides[] = ['type' => 'embed', 'src' => $embedUrl, 'alt' => $property->title];
        }
        if (!empty($property->cover_image)) {
            $mediaSlides[] = ['type' => 'image', 'src' => $property->cover_image, 'alt' => $property->title];
            $imageSlides[] = ['type' => 'image', 'src' => $property->cover_image, 'alt' => $property->title];
        }
        if (is_array($property->gallery)) {
            foreach ($property->gallery as $g) {
                if ($g) {
                    $mediaSlides[] = ['type' => 'image', 'src' => $g, 'alt' => $property->title];
                    $imageSlides[] = ['type' => 'image', 'src' => $g, 'alt' => $property->title];
                }
            }
        }
        // Map embed (best-effort for Google Maps)
        $mapEmbed = null;
        if (!empty($property->location_url)) {
            $mapEmbed = $property->location_url;
            $mapEmbed .= (str_contains($mapEmbed, '?') ? '&' : '?') . 'output=embed';
        }
        // Similar properties (same city & type)
        $similar = Property::query()
            ->where('id', '!=', $property->id)
            ->when($property->city, fn($q) => $q->where('city', $property->city))
            ->when($property->type, fn($q) => $q->where('type', $property->type))
            ->latest()
            ->limit(6)
            ->get();
        $amenityIcons = [
            'parking'=>'bx-parking','elevator'=>'bx-elevator','pool'=>'bx-water','garden'=>'bx-leaf','maid'=>'bx-female-sign','furnished'=>'bx-chair','ac'=>'bx-wind','security'=>'bx-shield','balcony'=>'bx-building-house','rooftop'=>'bx-home-alt-2'
        ];
        $amenityLabels = [
            'parking'=>'موقف سيارات','elevator'=>'مصعد','pool'=>'مسبح','garden'=>'حديقة','maid'=>'غرفة خادمة','furnished'=>'مؤثثة','ac'=>'تكييف مركزي','security'=>'حراسة','balcony'=>'شرفة','rooftop'=>'سطح'
        ];
        return view('properties.show', compact('property','embedUrl','amenityIcons','amenityLabels','mediaSlides','imageSlides','mapEmbed','similar','isFavorited'));
    }

    public function create()
    {
        $amenityOptions = [
            'parking' => ['label' => 'موقف سيارات', 'icon' => 'bx-parking'],
            'elevator' => ['label' => 'مصعد', 'icon' => 'bx-elevator'],
            'pool' => ['label' => 'مسبح', 'icon' => 'bx-water'],
            'garden' => ['label' => 'حديقة', 'icon' => 'bx-leaf'],
            'maid' => ['label' => 'غرفة خادمة', 'icon' => 'bx-female-sign'],
            'furnished' => ['label' => 'مؤثثة', 'icon' => 'bx-chair'],
            'ac' => ['label' => 'تكييف مركزي', 'icon' => 'bx-wind'],
            'security' => ['label' => 'حراسة', 'icon' => 'bx-shield'],
            'balcony' => ['label' => 'شرفة', 'icon' => 'bx-building-house'],
            'rooftop' => ['label' => 'سطح', 'icon' => 'bx-home-alt-2'],
        ];
        return view('properties.create', compact('amenityOptions'));
    }

    public function store(Request $request)
    {
        // Permissive payload (no validation rules)
        $data = $this->validatePayload($request);
        $this->sanitizeNumericFields($data);
        try {
            $coverPath = null;
            if ($request->hasFile('cover')) {
                $dir = public_path('uploads');
                if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
                $ext = $request->file('cover')->getClientOriginalExtension();
                $name = 'prop_'.time().'_'.Str::random(6).'.'.$ext;
                $request->file('cover')->move($dir, $name);
                $coverPath = '/uploads/'.$name;
            }

            $property = new Property();
            $property->user_id = auth()->id();
            $property->title = $data['title'];
            $property->city = $data['city'];
            $property->district = $data['district'] ?? null;
            $property->type = $data['type'];
            $property->price = $data['price'];
            $property->area = $data['area'] ?? null;
            $property->bedrooms = $data['bedrooms'] ?? null;
            $property->bathrooms = $data['bathrooms'] ?? null;
            $property->description = $data['description'] ?? null;
            $property->amenities = $data['amenities'] ?? [];
            $property->cover_image = $coverPath;
            $property->location_url = $data['location_url'] ?? null;
            $property->video_url = $data['video_url'] ?? null;
            // Handle video upload
            if ($request->hasFile('video')) {
                $dir = public_path('uploads/videos');
                if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
                $ext = $request->file('video')->getClientOriginalExtension();
                $name = 'vid_'.time().'_'.Str::random(6).'.'.$ext;
                $request->file('video')->move($dir, $name);
                $property->video_path = '/uploads/videos/'.$name;
            }
            // Handle gallery images
            $galleryPaths = [];
            if ($request->hasFile('gallery')) {
                $gdir = public_path('uploads/gallery');
                if (!is_dir($gdir)) { @mkdir($gdir, 0777, true); }
                foreach ((array) $request->file('gallery') as $idx => $file) {
                    if (!$file) continue;
                    $ext = $file->getClientOriginalExtension();
                    $gname = 'gal_'.time().'_'.Str::random(6).'_'.$idx.'.'.$ext;
                    $file->move($gdir, $gname);
                    $galleryPaths[] = '/uploads/gallery/'.$gname;
                }
            }
            if (!empty($galleryPaths)) {
                $property->gallery = $galleryPaths;
            }
            $property->is_featured = false;
            $property->save();

            return redirect()->route('properties.my')->with('ok', 'تم إضافة العقار بنجاح');
        } catch (\Throwable $e) {
            Log::error('Property store failed', ['error' => $e->getMessage()]);
            $fieldError = $this->parseDbError($e->getMessage());
            if ($fieldError) {
                return back()->withErrors($fieldError)->withInput();
            }
            return back()->withErrors(['general' => 'حدث خطأ غير متوقع أثناء حفظ العقار. يرجى مراجعة القيم والمحاولة مجددًا.'])->withInput();
        }
    }

    public function edit(Property $property)
    {
        abort_unless($property->user_id === auth()->id(), 403);
        $amenityOptions = [
            'parking' => ['label' => 'موقف سيارات', 'icon' => 'bx-parking'],
            'elevator' => ['label' => 'مصعد', 'icon' => 'bx-elevator'],
            'pool' => ['label' => 'مسبح', 'icon' => 'bx-water'],
            'garden' => ['label' => 'حديقة', 'icon' => 'bx-leaf'],
            'maid' => ['label' => 'غرفة خادمة', 'icon' => 'bx-female-sign'],
            'furnished' => ['label' => 'مؤثثة', 'icon' => 'bx-chair'],
            'ac' => ['label' => 'تكييف مركزي', 'icon' => 'bx-wind'],
            'security' => ['label' => 'حراسة', 'icon' => 'bx-shield'],
            'balcony' => ['label' => 'شرفة', 'icon' => 'bx-building-house'],
            'rooftop' => ['label' => 'سطح', 'icon' => 'bx-home-alt-2'],
        ];
        return view('properties.edit', compact('property','amenityOptions'));
    }

    public function update(Request $request, Property $property)
    {
        abort_unless($property->user_id === auth()->id(), 403);
        $data = $this->validatePayload($request, updating: true);
        $this->sanitizeNumericFields($data);

        try {
            if ($request->hasFile('cover')) {
                $dir = public_path('uploads');
                if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
                $ext = $request->file('cover')->getClientOriginalExtension();
                $name = 'prop_'.time().'_'.Str::random(6).'.'.$ext;
                $request->file('cover')->move($dir, $name);
                $property->cover_image = '/uploads/'.$name;
            }

            $property->title = $data['title'];
            $property->city = $data['city'];
            $property->district = $data['district'] ?? null;
            $property->type = $data['type'];
            $property->price = $data['price'];
            $property->area = $data['area'] ?? null;
            $property->bedrooms = $data['bedrooms'] ?? null;
            $property->bathrooms = $data['bathrooms'] ?? null;
            $property->description = $data['description'] ?? null;
            $property->location_url = $data['location_url'] ?? null;
            $property->video_url = $data['video_url'] ?? null;
            if ($request->hasFile('video')) {
                $dir = public_path('uploads/videos');
                if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
                $ext = $request->file('video')->getClientOriginalExtension();
                $name = 'vid_'.time().'_'.Str::random(6).'.'.$ext;
                $request->file('video')->move($dir, $name);
                $property->video_path = '/uploads/videos/'.$name;
            }
            // Append new gallery images if provided
            if ($request->hasFile('gallery')) {
                $existing = is_array($property->gallery) ? $property->gallery : [];
                $gdir = public_path('uploads/gallery');
                if (!is_dir($gdir)) { @mkdir($gdir, 0777, true); }
                foreach ((array) $request->file('gallery') as $idx => $file) {
                    if (!$file) continue;
                    $ext = $file->getClientOriginalExtension();
                    $gname = 'gal_'.time().'_'.Str::random(6).'_'.$idx.'.'.$ext;
                    $file->move($gdir, $gname);
                    $existing[] = '/uploads/gallery/'.$gname;
                }
                $property->gallery = $existing;
            }
            $property->save();

            return redirect()->route('properties.my')->with('ok', 'تم تحديث العقار بنجاح');
        } catch (\Throwable $e) {
            Log::error('Property update failed', ['error' => $e->getMessage()]);
            $fieldError = $this->parseDbError($e->getMessage());
            if ($fieldError) {
                return back()->withErrors($fieldError)->withInput();
            }
            return back()->withErrors(['general' => 'حدث خطأ غير متوقع أثناء تحديث العقار. يرجى مراجعة القيم والمحاولة مجددًا.'])->withInput();
        }
    }

    public function destroy(Property $property)
    {
        abort_unless($property->user_id === auth()->id(), 403);
        $property->delete();
        return redirect()->route('properties.my')->with('ok', 'تم حذف العقار');
    }

    public function my(Request $request)
    {
        $properties = Property::query()->where('user_id', auth()->id())->latest()->paginate(8);
        $amenityOptions = [
            'parking' => ['label' => 'موقف سيارات', 'icon' => 'bx-parking'],
            'elevator' => ['label' => 'مصعد', 'icon' => 'bx-elevator'],
            'pool' => ['label' => 'مسبح', 'icon' => 'bx-water'],
            'garden' => ['label' => 'حديقة', 'icon' => 'bx-leaf'],
            'maid' => ['label' => 'غرفة خادمة', 'icon' => 'bx-female-sign'],
            'furnished' => ['label' => 'مؤثثة', 'icon' => 'bx-chair'],
            'ac' => ['label' => 'تكييف مركزي', 'icon' => 'bx-wind'],
            'security' => ['label' => 'حراسة', 'icon' => 'bx-shield'],
            'balcony' => ['label' => 'شرفة', 'icon' => 'bx-building-house'],
            'rooftop' => ['label' => 'سطح', 'icon' => 'bx-home-alt-2'],
        ];
        return view('properties.my', compact('properties','amenityOptions'));
    }

    private function validatePayload(Request $request, bool $updating = false): array
    {
        // Return inputs as-is (no validation). Provide defaults to avoid notices.
        return [
            'title' => $request->input('title'),
            'city' => $request->input('city'),
            'district' => $request->input('district'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'area' => $request->input('area'),
            'bedrooms' => $request->input('bedrooms'),
            'bathrooms' => $request->input('bathrooms'),
            'description' => $request->input('description'),
            'location_url' => $request->input('location_url'),
            'video_url' => $request->input('video_url'),
            'amenities' => array_values((array) $request->input('amenities', [])),
            // files handled separately: cover, gallery[], video
        ];
    }

    // ===== Helpers: واضحة ومباشرة =====
    private function sanitizeNumericFields(array &$data): void
    {
        $toInt = function ($v) {
            if ($v === null || $v === '') return null;
            if (is_numeric($v)) return (int)$v;
            $clean = preg_replace('/[^0-9\-]/', '', (string)$v);
            return ($clean === '' || $clean === '-') ? null : (int)$clean;
        };

        $maxInt = 2147483647; // MySQL INT max
        $maxCnt = 255;        // حد منطقي لعدد الغرف/الحمّامات

        $v = $toInt($data['price'] ?? null);
        $data['price'] = $v !== null ? max(0, min($v, $maxInt)) : null;

        $v = $toInt($data['area'] ?? null);
        $data['area'] = $v !== null ? max(0, min($v, $maxInt)) : null;

        $v = $toInt($data['bedrooms'] ?? null);
        $data['bedrooms'] = $v !== null ? max(0, min($v, $maxCnt)) : null;

        $v = $toInt($data['bathrooms'] ?? null);
        $data['bathrooms'] = $v !== null ? max(0, min($v, $maxCnt)) : null;
    }

    private function parseDbError(string $message): ?array
    {
        $map = [
            'price' => 'قيمة السعر غير صالحة أو كبيرة جدًا.',
            'area' => 'قيمة المساحة غير صالحة.',
            'bedrooms' => 'قيمة عدد الغرف غير صالحة.',
            'bathrooms' => 'قيمة عدد الحمّامات غير صالحة.',
            'amenities' => 'تنسيق المميزات غير صالح.',
        ];
        $msg = strtolower($message);
        if (str_contains($msg, 'out of range') || str_contains($msg, 'incorrect integer value') || str_contains($msg, 'data too long')) {
            foreach ($map as $col => $friendly) {
                if (str_contains($msg, "'{$col}'")) {
                    return [$col => $friendly];
                }
            }
        }
        return null;
    }
}
