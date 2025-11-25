<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = Property::query();

        if ($request->filled('q')) {
            $term = trim($request->string('q'));
            $q->where(function($w) use ($term){
                $w->where('title','like',"%{$term}%")
                  ->orWhere('city','like',"%{$term}%")
                  ->orWhere('district','like',"%{$term}%")
                  ->orWhere('type','like',"%{$term}%");
            });
        }
        if ($request->filled('city')) {
            $q->where('city', $request->string('city'));
        }
        if ($request->filled('type')) {
            $q->where('type', $request->string('type'));
        }
        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }
        if ($request->filled('featured')) {
            $q->where('is_featured', (bool)$request->input('featured'));
        }

        $sortable = ['title','city','price','is_featured','id'];
        $sort = in_array($request->string('sort'), $sortable, true) ? $request->string('sort') : 'id';
        $dir  = $request->string('dir') === 'asc' ? 'asc' : 'desc';
        $q->orderBy($sort, $dir);

        $perPage = (int)$request->input('per_page', 20);
        if (!in_array($perPage, [10,20,50,100], true)) { $perPage = 20; }

        $properties = $q->paginate($perPage)->appends($request->query());

        $cities = Property::query()->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $types  = Property::query()->select('type')->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');

        return view('admin.properties.index', compact('properties','cities','types','sort','dir','perPage'));
    }

    public function create()
    {
        $cities = Property::query()->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $types  = Property::query()->select('type')->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');
        $districts = Property::query()->select('district')->whereNotNull('district')->distinct()->orderBy('district')->pluck('district');
        $riyadhDistricts = collect([
            'الياسمين','العقيق','النرجس','الملقا','العارض','القيروان','حطين','الصحافة','الربيع','النخيل','المصيف','الواحة','المروج',
            'قرطبة','الحمراء','أشبيلية','المونسية','غرناطة','الجزيرة','الخليج','النهضة','الروضة','الفيحاء','الروابي',
            'ظهرة لبن','نمار','طويق','عرقة','العزيزية','الشفا','السويدي','العريجاء','الدريهمية','البديعة','منفوحة','العزيزية الصناعية'
        ]);
        $districts = $riyadhDistricts->merge($districts)->unique()->sort()->values();
        $typeOptions = [
            'apartment' => 'شقة',
            'villa'     => 'فيلا',
            'duplex'    => 'دوبلكس',
            'floor'     => 'دور',
            'land'      => 'أرض',
            'office'    => 'مكتب',
            'shop'      => 'محل',
            'farm'      => 'مزرعة',
            'warehouse' => 'مستودع',
        ];
        $statuses = ['جاهز للسكن','تحت الإنشاء','معروض'];
        $amenityOptions = [
            'parking' => ['label'=>'موقف سيارة','icon'=>'bi-car-front'],
            'elevator' => ['label'=>'مصعد','icon'=>'bi-building-up'],
            'central_ac' => ['label'=>'تكييف مركزي','icon'=>'bi-wind'],
            'split_ac' => ['label'=>'مكيفات سبليت','icon'=>'bi-snow'],
            'furnished' => ['label'=>'مفروش','icon'=>'bi-house-check'],
            'balcony' => ['label'=>'بلكونة','icon'=>'bi-building'],
            'maid_room' => ['label'=>'غرفة خادمة','icon'=>'bi-person-badge'],
            'driver_room' => ['label'=>'غرفة سائق','icon'=>'bi-person-vcard'],
            'pool' => ['label'=>'مسبح','icon'=>'bi-water'],
            'garden' => ['label'=>'حديقة','icon'=>'bi-tree'],
            'roof' => ['label'=>'سطح','icon'=>'bi-house'],
            'basement' => ['label'=>'قبو','icon'=>'bi-box'],
            'security' => ['label'=>'حراسة','icon'=>'bi-shield-lock'],
            'cameras' => ['label'=>'كاميرات','icon'=>'bi-camera-video'],
            'smart_home' => ['label'=>'منزل ذكي','icon'=>'bi-cpu'],
            'solar' => ['label'=>'طاقة شمسية','icon'=>'bi-brightness-high'],
            'fireplace' => ['label'=>'مدفأة','icon'=>'bi-fire'],
            'laundry_room' => ['label'=>'غرفة غسيل','icon'=>'bi-basket'],
            'storage' => ['label'=>'مستودع','icon'=>'bi-archive'],
            'playground' => ['label'=>'ملعب','icon'=>'bi-emoji-smile'],
            'gym' => ['label'=>'نادي رياضي','icon'=>'bi-dumbbell'],
            'clubhouse' => ['label'=>'نادي اجتماعي','icon'=>'bi-people'],
            'sea_view' => ['label'=>'إطلالة بحرية','icon'=>'bi-water'],
            'corner' => ['label'=>'زاوية','icon'=>'bi-sign-turn-right'],
            'two_streets' => ['label'=>'شارعين','icon'=>'bi-signpost-split'],
            'near_metro' => ['label'=>'قريب مترو','icon'=>'bi-train-front'],
            'near_mall' => ['label'=>'قريب مول','icon'=>'bi-bag'],
            'schools' => ['label'=>'قريب مدارس','icon'=>'bi-mortarboard'],
            'hospitals' => ['label'=>'قريب مستشفيات','icon'=>'bi-hospital'],
            'mosques' => ['label'=>'قريب مساجد','icon'=>'bi-moon-stars'],
            'supermarket' => ['label'=>'قريب سوبرماركت','icon'=>'bi-basket2'],
            'private_entrance' => ['label'=>'مدخل خاص','icon'=>'bi-door-closed'],
            'duplex' => ['label'=>'دوبلكس','icon'=>'bi-columns-gap'],
            'annex' => ['label'=>'ملحق','icon'=>'bi-house-add'],
            'new_build' => ['label'=>'بناء جديد','icon'=>'bi-stars'],
            'renovated' => ['label'=>'مجدّد','icon'=>'bi-brush'],
            'open_kitchen' => ['label'=>'مطبخ مفتوح','icon'=>'bi-layout-sidebar-inset'],
            'closed_kitchen' => ['label'=>'مطبخ مغلق','icon'=>'bi-layout-sidebar'],
            'marble_floor' => ['label'=>'أرضيات رخام','icon'=>'bi-grid-3x3'],
            'ceramic_floor' => ['label'=>'أرضيات سيراميك','icon'=>'bi-grid-1x2'],
            'wooden_floor' => ['label'=>'أرضيات خشب','icon'=>'bi-grip-horizontal'],
            'water_well' => ['label'=>'بئر ماء','icon'=>'bi-droplet'],
            'electricity' => ['label'=>'كهرباء','icon'=>'bi-lightning-charge'],
            'asphalt' => ['label'=>'سفلت','icon'=>'bi-road'],
            'deed' => ['label'=>'صك','icon'=>'bi-file-earmark-text'],
            'mortgage_ok' => ['label'=>'قبول رهن','icon'=>'bi-bank'],
            'installments' => ['label'=>'أقساط','icon'=>'bi-calendar2-check'],
            'negotiable' => ['label'=>'قابل للتفاوض','icon'=>'bi-handshake'],
        ];
        return view('admin.properties.create', compact('cities','types','districts','statuses','typeOptions','amenityOptions'));
    }

    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title'].'-'.uniqid());
        $data['is_featured'] = (bool)($data['is_featured'] ?? false);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('images/properties', 'public');
        }

        if ($request->hasFile('video_file')) {
            $data['video_path'] = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = null;
        } elseif (!empty($data['video_url'])) {
            $data['video_url'] = $this->normalizeYouTubeUrl($data['video_url']);
            $data['video_path'] = null;
        }

        // Amenities: prefer static checkbox list if provided, otherwise parse comma-separated
        if (is_array($request->input('amenities_list'))) {
            $data['amenities'] = array_values(array_filter($request->input('amenities_list')));
        } elseif ($request->filled('amenities')) {
            $ams = collect(explode(',', (string)$request->input('amenities')))
                ->map(fn($v)=>trim($v))
                ->filter()
                ->values()
                ->all();
            $data['amenities'] = $ams;
        }

        // Gallery multiple images upload
        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                if ($img && $img->isValid()) {
                    $gallery[] = $img->store('images/properties', 'public');
                }
            }
        }
        if (!empty($gallery)) {
            $data['gallery'] = $gallery;
        }

        $property = Property::create($data);

        if ($request->input('redirect') === 'create') {
            return redirect()->route('admin.properties.create')->with('status', __('تم إنشاء العقار بنجاح، يمكنك إضافة عقار آخر'));
        }
        return redirect()->route('admin.properties.edit', $property)->with('status', __('تم إنشاء العقار بنجاح'));
    }

    public function edit(Property $property)
    {
        $cities = Property::query()->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $types  = Property::query()->select('type')->whereNotNull('type')->distinct()->orderBy('type')->pluck('type');
        $districts = Property::query()->select('district')->whereNotNull('district')->distinct()->orderBy('district')->pluck('district');
        $riyadhDistricts = collect([
            'الياسمين','العقيق','النرجس','الملقا','العارض','القيروان','حطين','الصحافة','الربيع','النخيل','المصيف','الواحة','المروج',
            'قرطبة','الحمراء','أشبيلية','المونسية','غرناطة','الجزيرة','الخليج','النهضة','الروضة','الفيحاء','الروابي',
            'ظهرة لبن','نمار','طويق','عرقة','العزيزية','الشفا','السويدي','العريجاء','الدريهمية','البديعة','منفوحة','العزيزية الصناعية'
        ]);
        $districts = $riyadhDistricts->merge($districts)->unique()->sort()->values();
        $typeOptions = [
            'apartment' => 'شقة',
            'villa'     => 'فيلا',
            'duplex'    => 'دوبلكس',
            'floor'     => 'دور',
            'land'      => 'أرض',
            'office'    => 'مكتب',
            'shop'      => 'محل',
            'farm'      => 'مزرعة',
            'warehouse' => 'مستودع',
        ];
        $statuses = ['جاهز للسكن','تحت الإنشاء','معروض'];
        $amenityOptions = [
            'parking' => ['label'=>'موقف سيارة','icon'=>'bi-car-front'],
            'elevator' => ['label'=>'مصعد','icon'=>'bi-building-up'],
            'central_ac' => ['label'=>'تكييف مركزي','icon'=>'bi-wind'],
            'split_ac' => ['label'=>'مكيفات سبليت','icon'=>'bi-snow'],
            'furnished' => ['label'=>'مفروش','icon'=>'bi-house-check'],
            'balcony' => ['label'=>'بلكونة','icon'=>'bi-building'],
            'maid_room' => ['label'=>'غرفة خادمة','icon'=>'bi-person-badge'],
            'driver_room' => ['label'=>'غرفة سائق','icon'=>'bi-person-vcard'],
            'pool' => ['label'=>'مسبح','icon'=>'bi-water'],
            'garden' => ['label'=>'حديقة','icon'=>'bi-tree'],
            'roof' => ['label'=>'سطح','icon'=>'bi-house'],
            'basement' => ['label'=>'قبو','icon'=>'bi-box'],
            'security' => ['label'=>'حراسة','icon'=>'bi-shield-lock'],
            'cameras' => ['label'=>'كاميرات','icon'=>'bi-camera-video'],
            'smart_home' => ['label'=>'منزل ذكي','icon'=>'bi-cpu'],
            'solar' => ['label'=>'طاقة شمسية','icon'=>'bi-brightness-high'],
            'fireplace' => ['label'=>'مدفأة','icon'=>'bi-fire'],
            'laundry_room' => ['label'=>'غرفة غسيل','icon'=>'bi-basket'],
            'storage' => ['label'=>'مستودع','icon'=>'bi-archive'],
            'playground' => ['label'=>'ملعب','icon'=>'bi-emoji-smile'],
            'gym' => ['label'=>'نادي رياضي','icon'=>'bi-dumbbell'],
            'clubhouse' => ['label'=>'نادي اجتماعي','icon'=>'bi-people'],
            'sea_view' => ['label'=>'إطلالة بحرية','icon'=>'bi-water'],
            'corner' => ['label'=>'زاوية','icon'=>'bi-sign-turn-right'],
            'two_streets' => ['label'=>'شارعين','icon'=>'bi-signpost-split'],
            'near_metro' => ['label'=>'قريب مترو','icon'=>'bi-train-front'],
            'near_mall' => ['label'=>'قريب مول','icon'=>'bi-bag'],
            'schools' => ['label'=>'قريب مدارس','icon'=>'bi-mortarboard'],
            'hospitals' => ['label'=>'قريب مستشفيات','icon'=>'bi-hospital'],
            'mosques' => ['label'=>'قريب مساجد','icon'=>'bi-moon-stars'],
            'supermarket' => ['label'=>'قريب سوبرماركت','icon'=>'bi-basket2'],
            'private_entrance' => ['label'=>'مدخل خاص','icon'=>'bi-door-closed'],
            'duplex' => ['label'=>'دوبلكس','icon'=>'bi-columns-gap'],
            'annex' => ['label'=>'ملحق','icon'=>'bi-house-add'],
            'new_build' => ['label'=>'بناء جديد','icon'=>'bi-stars'],
            'renovated' => ['label'=>'مجدّد','icon'=>'bi-brush'],
            'open_kitchen' => ['label'=>'مطبخ مفتوح','icon'=>'bi-layout-sidebar-inset'],
            'closed_kitchen' => ['label'=>'مطبخ مغلق','icon'=>'bi-layout-sidebar'],
            'marble_floor' => ['label'=>'أرضيات رخام','icon'=>'bi-grid-3x3'],
            'ceramic_floor' => ['label'=>'أرضيات سيراميك','icon'=>'bi-grid-1x2'],
            'wooden_floor' => ['label'=>'أرضيات خشب','icon'=>'bi-grip-horizontal'],
            'water_well' => ['label'=>'بئر ماء','icon'=>'bi-droplet'],
            'electricity' => ['label'=>'كهرباء','icon'=>'bi-lightning-charge'],
            'asphalt' => ['label'=>'سفلت','icon'=>'bi-road'],
            'deed' => ['label'=>'صك','icon'=>'bi-file-earmark-text'],
            'mortgage_ok' => ['label'=>'قبول رهن','icon'=>'bi-bank'],
            'installments' => ['label'=>'أقساط','icon'=>'bi-calendar2-check'],
            'negotiable' => ['label'=>'قابل للتفاوض','icon'=>'bi-handshake'],
        ];
        return view('admin.properties.edit', compact('property','cities','types','districts','statuses','typeOptions','amenityOptions'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();
        $data['is_featured'] = (bool)($data['is_featured'] ?? false);

        if ($request->hasFile('cover_image')) {
            if ($property->cover_image) {
                Storage::disk('public')->delete($property->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('images/properties', 'public');
        }

        if ($request->hasFile('video_file')) {
            if ($property->video_path) {
                Storage::disk('public')->delete($property->video_path);
            }
            $data['video_path'] = $request->file('video_file')->store('videos', 'public');
            $data['video_url'] = null;
        } elseif (!empty($data['video_url'])) {
            if ($property->video_path) {
                Storage::disk('public')->delete($property->video_path);
            }
            $data['video_url'] = $this->normalizeYouTubeUrl($data['video_url']);
            $data['video_path'] = null;
        }

        // Amenities update: prefer checkbox list
        if (is_array($request->input('amenities_list'))) {
            $data['amenities'] = array_values(array_filter($request->input('amenities_list')));
        } elseif ($request->has('amenities')) {
            $ams = collect(explode(',', (string)$request->input('amenities')))
                ->map(fn($v)=>trim($v))
                ->filter()
                ->values()
                ->all();
            $data['amenities'] = $ams;
        }

        // Gallery updates: remove selected + add new uploads
        $current = is_array($property->gallery ?? null) ? $property->gallery : [];
        $remove = (array)$request->input('remove_gallery', []);
        if (!empty($remove)) {
            foreach ($remove as $path) {
                Storage::disk('public')->delete($path);
            }
            $current = array_values(array_diff($current, $remove));
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $img) {
                if ($img && $img->isValid()) {
                    $current[] = $img->store('images/properties', 'public');
                }
            }
        }
        $data['gallery'] = $current;

        $property->update($data);

        return redirect()->route('admin.properties.edit', $property)->with('status', __('تم تحديث العقار بنجاح'));
    }

    public function destroy(Property $property)
    {
        if ($property->cover_image) {
            Storage::disk('public')->delete($property->cover_image);
        }
        if ($property->video_path) {
            Storage::disk('public')->delete($property->video_path);
        }
        $property->delete();
        return redirect()->route('admin.properties.index')->with('status', __('تم حذف العقار'));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = (array)$request->input('ids', []);
        $items = Property::query()->whereIn('id', $ids)->get();
        foreach ($items as $property) {
            if ($property->cover_image) { Storage::disk('public')->delete($property->cover_image); }
            if ($property->video_path) { Storage::disk('public')->delete($property->video_path); }
            $property->delete();
        }
        return redirect()->route('admin.properties.index')->with('status', __('تم حذف العناصر المحددة'));
    }

    public function toggleFeatured(Request $request, Property $property)
    {
        $property->is_featured = !$property->is_featured;
        $property->save();
        if ($request->wantsJson()) {
            return response()->json(['ok'=>true, 'is_featured'=>$property->is_featured]);
        }
        return back();
    }

    protected function normalizeYouTubeUrl(?string $url): ?string
    {
        if (!$url) return null;
        $url = trim($url);
        if (preg_match('~(?:youtu\.be/|v=)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }
        return $url;
    }
}
