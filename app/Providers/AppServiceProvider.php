<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share branding / layout settings with all views
        $siteTitle        = 'مؤسسة طور البناء للتجارة | أدوات البناء والسباكة والصحية والكهربائية والعدد';
        $siteLogo         = '/assets/top.png';
        // Default to the standard favicon path; admin settings can still override it
        $favicon          = '/favicon.ico';
        $colorPrimary     = '#c0ae8a';
        $colorBg          = '#ffffff';
        $colorFg          = '#051461';
        $colorStrong      = $colorFg;
        $colorPrimaryDark = '#fcae41';
        $colorBgDark      = '#020617';
        $colorFgDark      = '#f9fafb';
        $colorStrongDark  = $colorFgDark;
        $whatsappNumber   = config('app.whatsapp_number', '966000000000');

        if (Schema::hasTable('settings')) {
            $siteTitle        = Setting::getValue('site_title', $siteTitle);
            $siteLogo         = Setting::getValue('site_logo', $siteLogo);
            $favicon          = Setting::getValue('site_favicon', $favicon);
            $colorPrimary     = Setting::getValue('color_primary', $colorPrimary);
            $colorBg          = Setting::getValue('color_bg', $colorBg);
            $colorFg          = Setting::getValue('color_fg', $colorFg);
            $colorStrong      = Setting::getValue('color_strong', $colorStrong);
            $colorPrimaryDark = Setting::getValue('color_primary_dark', $colorPrimaryDark);
            $colorBgDark      = Setting::getValue('color_bg_dark', $colorBgDark);
            $colorFgDark      = Setting::getValue('color_fg_dark', $colorFgDark);
            $colorStrongDark  = Setting::getValue('color_strong_dark', $colorStrongDark);
            $whatsappNumber   = Setting::getValue('whatsapp_number', $whatsappNumber);
        }

        $ogImage = $siteLogo;

        // Build an absolute URL for social previews. If the stored value is already
        // an absolute URL (starts with http/https) we use it as-is; otherwise we
        // rely on Laravel's url() helper to generate a full URL for the current app.
        $ogImageUrl = $ogImage;
        if (! empty($ogImage) && ! Str::startsWith($ogImage, ['http://', 'https://'])) {
            $ogImageUrl = url($ogImage);
        }

        // Unified social preview image used by Open Graph / Twitter, with safe
        // fallbacks all handled at the PHP layer (not inside Blade views).
        $socialImage = $ogImageUrl
            ?: ($ogImage ? url($ogImage) : ($siteLogo ? url($siteLogo) : asset('img/logo/1.png')));

        // Organization schema (JSON-LD) shared with views that need rich
        // snippets, e.g. the landing page.
        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => 'شركة مدى الذهبية',
            'url'      => url('/'),
            'logo'     => $socialImage,
            'description' => 'شركة عقارية تقدم خدمات شراء وبيع وتأجير وإدارة أملاك، تقييم وتسويق عقاري واستشارات استثمارية، بخبرة محلية ورؤية احترافية.',
            'sameAs'   => [],
        ];

        View::share([
            'siteTitle'        => $siteTitle,
            'siteLogo'         => $siteLogo,
            'favicon'          => $favicon,
            'ogImage'          => $ogImage,
            'ogImageUrl'       => $ogImageUrl,
            'socialImage'      => $socialImage,
            'colorPrimary'     => $colorPrimary,
            'colorBg'          => $colorBg,
            'colorFg'          => $colorFg,
            'colorStrong'      => $colorStrong,
            'colorPrimaryDark' => $colorPrimaryDark,
            'colorBgDark'      => $colorBgDark,
            'colorFgDark'      => $colorFgDark,
            'colorStrongDark'  => $colorStrongDark,
            'whatsappNumber'   => $whatsappNumber,
            'organizationSchema' => $organizationSchema,
        ]);
    }
}
