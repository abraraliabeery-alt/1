<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingAdminController extends Controller
{
    public function editSocial()
    {
        $data = [
            'whatsapp_number' => Setting::getValue('whatsapp_number', ''),
            'contact_phone'   => Setting::getValue('contact_phone', ''),
            'contact_email'   => Setting::getValue('contact_email', ''),
            'social_twitter'  => Setting::getValue('social_twitter', ''),
            'social_instagram'=> Setting::getValue('social_instagram', ''),
            'social_linkedin' => Setting::getValue('social_linkedin', ''),
            'social_facebook' => Setting::getValue('social_facebook', ''),
            'social_tiktok'   => Setting::getValue('social_tiktok', ''),
            'social_youtube'  => Setting::getValue('social_youtube', ''),

            'show_social_whatsapp'  => (bool) Setting::getValue('show_social_whatsapp', '1'),
            'show_social_twitter'   => (bool) Setting::getValue('show_social_twitter', '1'),
            'show_social_instagram' => (bool) Setting::getValue('show_social_instagram', '1'),
            'show_social_linkedin'  => (bool) Setting::getValue('show_social_linkedin', '1'),
            'show_social_facebook'  => (bool) Setting::getValue('show_social_facebook', '1'),
            'show_social_tiktok'    => (bool) Setting::getValue('show_social_tiktok', '1'),
            'show_social_youtube'   => (bool) Setting::getValue('show_social_youtube', '1'),
        ];
        return view('admin.settings.social', $data);
    }

    public function updateSocial(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => ['nullable','string','max:30'],
            'contact_phone'   => ['nullable','string','max:50'],
            'contact_email'   => ['nullable','email','max:120'],
            'social_twitter'  => ['nullable','url'],
            'social_instagram'=> ['nullable','url'],
            'social_linkedin' => ['nullable','url'],
            'social_facebook' => ['nullable','url'],
            'social_tiktok'   => ['nullable','url'],
            'social_youtube'  => ['nullable','url'],

            'show_social_whatsapp'  => ['nullable','in:on'],
            'show_social_twitter'   => ['nullable','in:on'],
            'show_social_instagram' => ['nullable','in:on'],
            'show_social_linkedin'  => ['nullable','in:on'],
            'show_social_facebook'  => ['nullable','in:on'],
            'show_social_tiktok'    => ['nullable','in:on'],
            'show_social_youtube'   => ['nullable','in:on'],
        ]);

        // Normalize inputs
        $clean = array_map(function($v){ return is_string($v) ? trim($v) : $v; }, $validated);
        if (!empty($clean['whatsapp_number'])) {
            $clean['whatsapp_number'] = preg_replace('/[^0-9]/', '', $clean['whatsapp_number']);
        }
        if (!empty($clean['contact_phone'])) {
            $clean['contact_phone'] = preg_replace('/\s+/', ' ', $clean['contact_phone']);
        }

        $values = $clean;
        foreach (['whatsapp','twitter','instagram','linkedin','facebook','tiktok','youtube'] as $k) {
            $values['show_social_'.$k] = isset($validated['show_social_'.$k]) ? '1' : '0';
        }

        Setting::setValues($values);

        return redirect()->route('admin.settings.social.edit')->with('ok', 'تم تحديث الإعدادات بنجاح');
    }

    public function editSections()
    {
        $theme = config('app.theme', 'theme1');

        $data = [
            'theme' => $theme,

            // Unified section toggles (show_*). Backward compatible with older keys.
            'show_properties'   => (bool) Setting::getValue('show_properties', Setting::getValue('t1_show_properties', '1')),
            'show_kpis'         => (bool) Setting::getValue('show_kpis', Setting::getValue('t1_show_kpis', '1')),
            'show_tiles'        => (bool) Setting::getValue('show_tiles', Setting::getValue('t1_show_tiles', '1')),
            'show_about'        => (bool) Setting::getValue('show_about', Setting::getValue('t1_show_about', '1')),
            'show_services'     => (bool) Setting::getValue('show_services', Setting::getValue('t1_show_services', '1')),
            'show_partners'     => (bool) Setting::getValue('show_partners', Setting::getValue('t1_show_partners', '1')),
            'show_testimonials' => (bool) Setting::getValue('show_testimonials', Setting::getValue('t1_show_testimonials', '1')),
            'show_cta'          => (bool) Setting::getValue('show_cta', Setting::getValue('t1_show_cta', '1')),
            'show_contact'      => (bool) Setting::getValue('show_contact', Setting::getValue('t1_show_contact', '1')),
            'show_projects'     => (bool) Setting::getValue('show_projects', Setting::getValue('show_portfolio', '1')),
            'show_faqs'         => (bool) Setting::getValue('show_faqs', '1'),
        ];

        return view('admin.settings.sections', $data);
    }

    public function updateSections(Request $request)
    {
        $validated = $request->validate([
            'show_properties'   => ['nullable','in:on'],
            'show_kpis'         => ['nullable','in:on'],
            'show_tiles'        => ['nullable','in:on'],
            'show_about'        => ['nullable','in:on'],
            'show_services'     => ['nullable','in:on'],
            'show_partners'     => ['nullable','in:on'],
            'show_testimonials' => ['nullable','in:on'],
            'show_cta'          => ['nullable','in:on'],
            'show_contact'      => ['nullable','in:on'],
            'show_projects'     => ['nullable','in:on'],
            'show_faqs'         => ['nullable','in:on'],
        ]);

        $values = [
            'show_properties'   => isset($validated['show_properties']) ? '1' : '0',
            'show_kpis'         => isset($validated['show_kpis']) ? '1' : '0',
            'show_tiles'        => isset($validated['show_tiles']) ? '1' : '0',
            'show_about'        => isset($validated['show_about']) ? '1' : '0',
            'show_services'     => isset($validated['show_services']) ? '1' : '0',
            'show_partners'     => isset($validated['show_partners']) ? '1' : '0',
            'show_testimonials' => isset($validated['show_testimonials']) ? '1' : '0',
            'show_cta'          => isset($validated['show_cta']) ? '1' : '0',
            'show_contact'      => isset($validated['show_contact']) ? '1' : '0',
            'show_projects'     => isset($validated['show_projects']) ? '1' : '0',
            'show_faqs'         => isset($validated['show_faqs']) ? '1' : '0',
        ];

        Setting::setValues($values);

        return redirect()->route('admin.settings.sections.edit')->with('ok', 'تم تحديث ظهور الأقسام');
    }

    public function editBranding()
    {
        $data = [
            'site_logo'    => Setting::getValue('site_logo', '/assets/top.png'),
            'site_logo_dark' => Setting::getValue('site_logo_dark', Setting::getValue('site_logo', '/assets/top.png')),
            'site_favicon' => Setting::getValue('site_favicon', '/assets/favicon.svg'),
            'site_title'   => Setting::getValue('site_title', 'توب ليفل | حلول المنازل والمكاتب الذكية'),
            'color_primary' => Setting::getValue('color_primary', '#fcae41'),
            'color_bg'      => Setting::getValue('color_bg', '#ffffff'),
            'color_fg'      => Setting::getValue('color_fg', '#000000'),
            'color_strong'  => Setting::getValue('color_strong', '#000000'),
            // ألوان الوضع الداكن (3 ألوان + لون نص قوي)
            'color_primary_dark' => Setting::getValue('color_primary_dark', '#fcae41'),
            'color_bg_dark'      => Setting::getValue('color_bg_dark', '#020617'),
            'color_fg_dark'      => Setting::getValue('color_fg_dark', '#f9fafb'),
            'color_strong_dark'  => Setting::getValue('color_strong_dark', '#f9fafb'),
            'hero_image'   => Setting::getValue('hero_image', '/assets/hero-smart-home.jpg'),
        ];
        return view('admin.settings.branding', $data);
    }

    public function updateBranding(Request $request)
    {
        $validated = $request->validate([
            'site_title'   => ['nullable','string','max:120'],
            'site_logo'    => ['nullable','image','mimes:png,jpg,jpeg,webp,svg'],
            'site_logo_dark' => ['nullable','image','mimes:png,jpg,jpeg,webp,svg'],
            'site_favicon' => ['nullable','mimes:png,jpg,jpeg,webp,ico,svg'],
            'favicon_same_logo' => ['nullable','in:on'],
            'color_primary' => ['nullable','string','max:20'],
            'color_bg'      => ['nullable','string','max:20'],
            'color_fg'      => ['nullable','string','max:20'],
            'color_strong'  => ['nullable','string','max:20'],
            'color_primary_dark' => ['nullable','string','max:20'],
            'color_bg_dark'      => ['nullable','string','max:20'],
            'color_fg_dark'      => ['nullable','string','max:20'],
            'color_strong_dark'  => ['nullable','string','max:20'],
            'hero_image'   => ['nullable','image','mimes:png,jpg,jpeg,webp,svg'],
        ]);

        $values = [];
        if (!empty($validated['site_title'])) {
            $values['site_title'] = trim($validated['site_title']);
        }
        // Colors (accept hex or css color strings as-is, trimmed)
        foreach (['color_primary','color_bg','color_fg','color_strong','color_primary_dark','color_bg_dark','color_fg_dark','color_strong_dark'] as $k) {
            if (isset($validated[$k]) && $validated[$k] !== '') {
                $values[$k] = trim($validated[$k]);
            }
        }

        $dir = public_path('uploads/branding');
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }

        // Track current logo path in case we need to reuse it as favicon
        $currentLogo = Setting::getValue('site_logo', '/assets/top.png');

        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $name = 'logo_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $currentLogo = '/uploads/branding/'.$name;
            $values['site_logo'] = $currentLogo;
        }

        if ($request->hasFile('site_logo_dark')) {
            $file = $request->file('site_logo_dark');
            $name = 'logo_dark_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $values['site_logo_dark'] = '/uploads/branding/'.$name;
        }
        if ($request->boolean('favicon_same_logo')) {
            $values['site_favicon'] = $currentLogo;
        } elseif ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $name = 'favicon_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $values['site_favicon'] = '/uploads/branding/'.$name;
        }

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $name = 'hero_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir, $name);
            $values['hero_image'] = '/uploads/branding/'.$name;
        }

        if ($values) {
            Setting::setValues($values);

            // إذا تم تحديث مسار الفافيكون، انسخ الملف إلى public/favicon.ico
            if (isset($values['site_favicon']) && $values['site_favicon']) {
                $faviconPath = public_path(ltrim($values['site_favicon'], '/'));
                if (is_file($faviconPath)) {
                    @copy($faviconPath, public_path('favicon.ico'));
                }
            }
        }

        return redirect()->route('admin.settings.branding.edit')->with('ok', 'تم تحديث إعدادات الهوية والألوان بنجاح');
    }
}
