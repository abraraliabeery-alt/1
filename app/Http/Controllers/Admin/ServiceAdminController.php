<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = Service::query()
            ->when($request->get('q'), function($q, $qstr){
                $qstr = trim($qstr);
                $q->where(function($qq) use ($qstr){
                    $qq->where('title','like','%'.$qstr.'%')
                       ->orWhere('excerpt','like','%'.$qstr.'%');
                });
            })
            ->orderBy('sort_order')
            ->orderByDesc('id');
        $services = $q->paginate(15)->withQueryString();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'cover_image_url' => 'nullable|url|max:1000',
            'cover_image_file' => 'nullable|image',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:draft,published',
        ]);
        $slugBase = Str::slug($data['title']);
        $slug = $slugBase;
        $i = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'.$i++;
        }
        $data['slug'] = $slug;
        // Cover image: URL takes precedence over upload
        $cover = null;
        if (!empty($data['cover_image_url'])) {
            $cover = $data['cover_image_url'];
        } elseif ($request->hasFile('cover_image_file')) {
            $dir = public_path('uploads/services');
            if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $file = $request->file('cover_image_file');
            $name = 'svc_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $cover = '/uploads/services/'.$name;
        }
        $data['cover_image'] = $cover;

        $data['is_featured'] = (bool)($data['is_featured'] ?? false);
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['status'] = $data['status'] ?? 'published';

        Service::create($data);
        return redirect()->route('admin.services.index')->with('ok', 'تم إنشاء الخدمة');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'cover_image_url' => 'nullable|url|max:1000',
            'cover_image_file' => 'nullable|image',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:draft,published',
        ]);
        $slugBase = Str::slug($data['title']);
        $slug = $slugBase;
        $i = 1;
        while (Service::where('slug', $slug)->where('id','!=',$service->id)->exists()) {
            $slug = $slugBase.'-'.$i++;
        }
        $data['slug'] = $slug;
        // Cover image update
        $cover = $service->cover_image;
        if (!empty($data['cover_image_url'])) {
            $cover = $data['cover_image_url'];
        } elseif ($request->hasFile('cover_image_file')) {
            $dir = public_path('uploads/services');
            if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $file = $request->file('cover_image_file');
            $name = 'svc_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $cover = '/uploads/services/'.$name;
        }
        $data['cover_image'] = $cover;

        $data['is_featured'] = (bool)($data['is_featured'] ?? false);
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['status'] = $data['status'] ?? 'published';

        $service->update($data);
        return redirect()->route('admin.services.index')->with('ok', 'تم تحديث الخدمة');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('ok', 'تم حذف الخدمة');
    }
}
