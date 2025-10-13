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
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string|max:255',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:draft,published',
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
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
            'slug' => 'nullable|string|max:255|unique:services,slug,'.$service->id,
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string|max:255',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:draft,published',
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
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
