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
        ]);

        // Normalize inputs
        $clean = array_map(function($v){ return is_string($v) ? trim($v) : $v; }, $validated);
        if (!empty($clean['whatsapp_number'])) {
            $clean['whatsapp_number'] = preg_replace('/[^0-9]/', '', $clean['whatsapp_number']);
        }
        if (!empty($clean['contact_phone'])) {
            $clean['contact_phone'] = preg_replace('/\s+/', ' ', $clean['contact_phone']);
        }

        Setting::setValues($clean);

        return redirect()->route('admin.settings.social.edit')->with('ok', 'تم تحديث الإعدادات بنجاح');
    }

    public function editSections()
    {
        $data = [
            'show_testimonials' => (bool) Setting::getValue('show_testimonials', '1'),
            'show_ip_pbx'       => (bool) Setting::getValue('show_ip_pbx', '1'),
            'show_servers'      => (bool) Setting::getValue('show_servers', '1'),
            'show_fingerprint'  => (bool) Setting::getValue('show_fingerprint', '1'),
            'show_portfolio'    => (bool) Setting::getValue('show_portfolio', '1'),
            'show_faqs'         => (bool) Setting::getValue('show_faqs', '1'),
        ];
        return view('admin.settings.sections', $data);
    }

    public function updateSections(Request $request)
    {
        $validated = $request->validate([
            'show_testimonials' => ['nullable','in:on'],
            'show_ip_pbx'       => ['nullable','in:on'],
            'show_servers'      => ['nullable','in:on'],
            'show_fingerprint'  => ['nullable','in:on'],
            'show_portfolio'    => ['nullable','in:on'],
            'show_faqs'         => ['nullable','in:on'],
        ]);

        $values = [
            'show_testimonials' => isset($validated['show_testimonials']) ? '1' : '0',
            'show_ip_pbx'       => isset($validated['show_ip_pbx']) ? '1' : '0',
            'show_servers'      => isset($validated['show_servers']) ? '1' : '0',
            'show_fingerprint'  => isset($validated['show_fingerprint']) ? '1' : '0',
            'show_portfolio'    => isset($validated['show_portfolio']) ? '1' : '0',
            'show_faqs'         => isset($validated['show_faqs']) ? '1' : '0',
        ];

        Setting::setValues($values);

        return redirect()->route('admin.settings.sections.edit')->with('ok', 'تم تحديث ظهور الأقسام');
    }

    public function editBranding()
    {
        $data = [
            'site_logo'    => Setting::getValue('site_logo', '/assets/top.png'),
            'site_favicon' => Setting::getValue('site_favicon', '/assets/favicon.svg'),
            'site_title'   => Setting::getValue('site_title', 'توب ليفل | حلول المنازل والمكاتب الذكية'),
            'color_primary' => Setting::getValue('color_primary', '#fcae41'),
            'color_bg'      => Setting::getValue('color_bg', '#ffffff'),
            'color_fg'      => Setting::getValue('color_fg', '#000000'),
            'color_card'    => Setting::getValue('color_card', '#ffffff'),
            'color_border'  => Setting::getValue('color_border', '#e6ecff'),
            'color_footer_bg' => Setting::getValue('color_footer_bg', '#000000'),
            'color_footer_fg' => Setting::getValue('color_footer_fg', '#ffffff'),
            'color_footer_accent' => Setting::getValue('color_footer_accent', '#fcae41'),
            'hero_image'   => Setting::getValue('hero_image', '/assets/hero-smart-home.jpg'),
        ];
        return view('admin.settings.branding', $data);
    }

    public function updateBranding(Request $request)
    {
        $validated = $request->validate([
            'site_title'   => ['nullable','string','max:120'],
            'site_logo'    => ['nullable','image','mimes:png,jpg,jpeg,webp,svg'],
            'site_favicon' => ['nullable','mimes:png,jpg,jpeg,webp,ico,svg'],
            'favicon_same_logo' => ['nullable','in:on'],
            'color_primary' => ['nullable','string','max:20'],
            'color_bg'      => ['nullable','string','max:20'],
            'color_fg'      => ['nullable','string','max:20'],
            'color_card'    => ['nullable','string','max:20'],
            'color_border'  => ['nullable','string','max:20'],
            'color_footer_bg' => ['nullable','string','max:20'],
            'color_footer_fg' => ['nullable','string','max:20'],
            'color_footer_accent' => ['nullable','string','max:20'],
            'hero_image'   => ['nullable','image','mimes:png,jpg,jpeg,webp,svg'],
        ]);

        $values = [];
        if (!empty($validated['site_title'])) {
            $values['site_title'] = trim($validated['site_title']);
        }
        // Colors (accept hex or css color strings as-is, trimmed)
        foreach (['color_primary','color_bg','color_fg','color_card','color_border','color_footer_bg','color_footer_fg','color_footer_accent'] as $k) {
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

        if ($values) { Setting::setValues($values); }

        return redirect()->route('admin.settings.branding.edit')->with('ok', 'تم تحديث إعدادات الهوية والألوان بنجاح');
    }
}
