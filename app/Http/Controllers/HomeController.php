<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\GalleryItem;
use App\Models\Partner;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Property;
use Illuminate\Support\Str;
 

class HomeController extends Controller
{
    public function index()
    {
        $theme = config('app.theme', 'theme1');

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

        $services = Service::query()
            ->where('status', 'published')
            ->where('type', 1)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $heroTitle = Setting::getValue('hero_title', 'خدمات المقاولات');
        $heroSubtitle = Setting::getValue('hero_subtitle', 'إبداعية واحترافية');
        $heroDescription = Setting::getValue('hero_description', 'نقدم حلول مقاولات متكاملة تشمل البناء، التشطيب، الصيانة، وإدارة المشاريع بأعلى معايير الجودة والسلامة.');

        $heroImage = Setting::getValue('hero_image', '/assets/hero-smart-home.jpg');
        $heroImageUrl = $heroImage;
        if (!empty($heroImage) && !Str::startsWith($heroImage, ['http://','https://'])) {
            $heroImageUrl = url(ltrim($heroImage, '/'));
        }

        $aboutTitle = Setting::getValue('about_title', 'من نحن');
        $aboutDescription = Setting::getValue('about_description', 'نقدم خدمات متكاملة تجمع بين الخبرة والاحترافية والالتزام بأعلى معايير الجودة.');
        $aboutImage = Setting::getValue('about_image', '');
        $aboutImageUrl = $aboutImage;
        if (!empty($aboutImage) && !Str::startsWith($aboutImage, ['http://','https://'])) {
            $aboutImageUrl = url(ltrim($aboutImage, '/'));
        }

        $stats = [
            [
                'value' => Setting::getValue('stats_1_value', '+850'),
                'label' => Setting::getValue('stats_1_label', 'مشروع منجز'),
            ],
            [
                'value' => Setting::getValue('stats_2_value', '+2500'),
                'label' => Setting::getValue('stats_2_label', 'عميل راضٍ'),
            ],
            [
                'value' => Setting::getValue('stats_3_value', '+120'),
                'label' => Setting::getValue('stats_3_label', 'موظف محترف'),
            ],
            [
                'value' => Setting::getValue('stats_4_value', '+15'),
                'label' => Setting::getValue('stats_4_label', 'سنة خبرة'),
            ],
        ];

        // Unified section toggles (show_*). Backward compatible with older keys.
        $show_properties   = (bool) Setting::getValue('show_properties', Setting::getValue('t1_show_properties', '1'));
        $show_kpis         = (bool) Setting::getValue('show_kpis', Setting::getValue('t1_show_kpis', '1'));
        $show_tiles        = (bool) Setting::getValue('show_tiles', Setting::getValue('t1_show_tiles', '1'));
        $show_about        = (bool) Setting::getValue('show_about', Setting::getValue('t1_show_about', '1'));
        $show_services     = (bool) Setting::getValue('show_services', Setting::getValue('t1_show_services', '1'));
        $show_partners     = (bool) Setting::getValue('show_partners', Setting::getValue('t1_show_partners', '1'));
        $show_testimonials = (bool) Setting::getValue('show_testimonials', Setting::getValue('t1_show_testimonials', '1'));
        $show_cta          = (bool) Setting::getValue('show_cta', Setting::getValue('t1_show_cta', '1'));
        $show_contact      = (bool) Setting::getValue('show_contact', Setting::getValue('t1_show_contact', '1'));
        $show_projects     = (bool) Setting::getValue('show_projects', Setting::getValue('show_portfolio', '1'));
        $show_faqs         = (bool) Setting::getValue('show_faqs', '1');

        $properties = Property::query()
            ->latest()
            ->limit(6)
            ->get();

        $view  = "themes.{$theme}.landing";

        if (!view()->exists($view)) {
            $view = 'themes.theme1.landing';
        }

        return view($view, compact(
            'projects','gallery','partners','faqs','testimonials','services',
            'show_properties','show_kpis','show_tiles','show_about','show_services','show_partners','show_testimonials','show_cta','show_contact','show_projects','show_faqs',
            'properties',
            'heroTitle','heroSubtitle','heroDescription','heroImageUrl',
            'aboutTitle','aboutDescription','aboutImageUrl',
            'stats'
        ));
    }
}
