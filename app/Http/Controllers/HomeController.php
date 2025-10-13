<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\GalleryItem;
use App\Models\Partner;
use App\Models\Faq;
use App\Models\Setting;
 

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->orderByDesc('is_featured')
            ->latest()
            ->limit(6)
            ->get();

        $gallery = GalleryItem::query()
            ->orderBy('sort_order')
            ->latest()
            ->limit(6)
            ->get();

        $testimonials = GalleryItem::query()
            ->where('category', 'testimonials')
            ->orderBy('sort_order')
            ->latest()
            ->limit(6)
            ->get();

        $partners = Partner::query()
            ->where('status','published')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $faqs = Faq::query()
            ->where('status','published')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        $show_testimonials = (bool) Setting::getValue('show_testimonials', '1');
        $show_ip_pbx       = (bool) Setting::getValue('show_ip_pbx', '1');
        $show_servers      = (bool) Setting::getValue('show_servers', '1');
        $show_fingerprint  = (bool) Setting::getValue('show_fingerprint', '1');
        $show_portfolio    = (bool) Setting::getValue('show_portfolio', '1');
        $show_faqs         = (bool) Setting::getValue('show_faqs', '1');

        return view('landing', compact(
            'projects','gallery','partners','faqs','testimonials',
            'show_testimonials','show_ip_pbx','show_servers','show_fingerprint','show_portfolio','show_faqs'
        ));
    }
}
