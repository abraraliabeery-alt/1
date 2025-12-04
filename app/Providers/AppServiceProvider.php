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
        $favicon          = '/assets/favicon.svg';
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
        // prefix it with the application URL.
        $ogImageUrl = $ogImage;
        if (! empty($ogImage) && ! Str::startsWith($ogImage, ['http://', 'https://'])) {
            $ogImageUrl = rtrim(config('app.url', ''), '/') . '/' . ltrim($ogImage, '/');
        }

        View::share([
            'siteTitle'        => $siteTitle,
            'siteLogo'         => $siteLogo,
            'favicon'          => $favicon,
            'ogImage'          => $ogImage,
            'ogImageUrl'       => $ogImageUrl,
            'colorPrimary'     => $colorPrimary,
            'colorBg'          => $colorBg,
            'colorFg'          => $colorFg,
            'colorStrong'      => $colorStrong,
            'colorPrimaryDark' => $colorPrimaryDark,
            'colorBgDark'      => $colorBgDark,
            'colorFgDark'      => $colorFgDark,
            'colorStrongDark'  => $colorStrongDark,
            'whatsappNumber'   => $whatsappNumber,
        ]);
    }
}
