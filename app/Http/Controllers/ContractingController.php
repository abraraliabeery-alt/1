<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Project;
use App\Models\Service;

class ContractingController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('status', 'published')
            ->where('type', 2)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $projects = Project::query()
            ->orderByDesc('is_featured')
            ->latest()
            ->limit(6)
            ->get();

        $testimonials = GalleryItem::query()
            ->where('category', 'testimonials')
            ->orderBy('sort_order')
            ->latest()
            ->limit(6)
            ->get();

        $theme = config('app.theme', 'theme1');
        $allowedThemes = ['theme1', 'theme2', 'theme3', 'theme4', 'theme5'];
        if (!in_array($theme, $allowedThemes, true)) {
            $theme = 'theme1';
        }

        $view  = "themes.{$theme}.contracting";

        if (!view()->exists($view)) {
            $view = 'themes.theme1.contracting';
        }

        return view($view, compact('services', 'projects', 'testimonials'));
    }
}
