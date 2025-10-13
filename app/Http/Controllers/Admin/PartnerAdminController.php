<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = Partner::query()
            ->when($request->get('q'), function($qq, $qstr){
                $qstr = trim($qstr);
                $qq->where(function($w) use ($qstr){
                    $w->where('name','like',"%$qstr%")
                      ->orWhere('website_url','like',"%$qstr%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name');
        $partners = $q->paginate(20)->withQueryString();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:190',
            'slug' => 'nullable|string|max:190|unique:partners,slug',
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:draft,published',
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['status'] = $data['status'] ?? 'published';
        Partner::create($data);
        return redirect()->route('admin.partners.index')->with('ok','تم إضافة الشريك');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'name' => 'required|string|max:190',
            'slug' => 'nullable|string|max:190|unique:partners,slug,'.$partner->id,
            'website_url' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|in:draft,published',
        ]);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['status'] = $data['status'] ?? 'published';
        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('ok','تم التحديث');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('ok','تم حذف الشريك');
    }
}
