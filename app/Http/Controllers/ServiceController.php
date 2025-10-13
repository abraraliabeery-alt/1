<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()
            ->when($request->get('q'), function($q, $qstr){
                $qstr = trim($qstr);
                $q->where(function($qq) use ($qstr){
                    $qq->where('title','like','%'.$qstr.'%')
                       ->orWhere('excerpt','like','%'.$qstr.'%')
                       ->orWhere('body','like','%'.$qstr.'%');
                });
            })
            ->where('status','published')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->where('status','published')->firstOrFail();
        return view('services.show', compact('service'));
    }
}
