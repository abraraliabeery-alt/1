<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SiteConfig
{
    public function sharedViewData(): array
    {
        $siteTitle        = 'مؤسسة طور البناء للتجارة | أدوات البناء والسباكة والصحية والكهربائية والعدد';
        $siteLogo         = '/assets/top.png';
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
        $socialTwitter    = null;
        $socialInstagram  = null;
        $socialLinkedin   = null;
        $socialFacebook   = null;
        $socialTiktok     = null;
        $socialYoutube    = null;
        $contactPhone     = null;
        $contactEmail     = null;

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
            $contactPhone     = Setting::getValue('contact_phone', $contactPhone);
            $contactEmail     = Setting::getValue('contact_email', $contactEmail);
            $socialTwitter    = Setting::getValue('social_twitter', $socialTwitter);
            $socialInstagram  = Setting::getValue('social_instagram', $socialInstagram);
            $socialLinkedin   = Setting::getValue('social_linkedin', $socialLinkedin);
            $socialFacebook   = Setting::getValue('social_facebook', $socialFacebook);
            $socialTiktok     = Setting::getValue('social_tiktok', $socialTiktok);
            $socialYoutube    = Setting::getValue('social_youtube', $socialYoutube);
        }

        $ogImage = $siteLogo;

        $ogImageUrl = $ogImage;
        if (! empty($ogImage) && ! Str::startsWith($ogImage, ['http://', 'https://'])) {
            $ogImageUrl = url($ogImage);
        }

        $socialImage = $ogImageUrl
            ?: ($ogImage ? url($ogImage) : ($siteLogo ? url($siteLogo) : asset('img/logo/1.png')));

        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => 'شركة مدى الذهبية',
            'url'      => url('/'),
            'logo'     => $socialImage,
            'description' => 'شركة عقارية تقدم خدمات شراء وبيع وتأجير وإدارة أملاك، تقييم وتسويق عقاري واستشارات استثمارية، بخبرة محلية ورؤية احترافية.',
            'sameAs'   => array_values(array_filter([
                $socialTwitter,
                $socialInstagram,
                $socialLinkedin,
                $socialFacebook,
                $socialTiktok,
                $socialYoutube,
            ])),
        ];

        $siteLogoUrl = $siteLogo;
        if (! empty($siteLogo) && ! Str::startsWith($siteLogo, ['http://', 'https://'])) {
            $siteLogoUrl = url($siteLogo);
        }

        $waDigits = $whatsappNumber ? preg_replace('/[^0-9]/', '', (string) $whatsappNumber) : '';
        $whatsappLink = $waDigits ? 'https://wa.me/'.$waDigits : null;

        $socialLinks = [
            'whatsapp' => $whatsappLink,
            'twitter'  => $socialTwitter,
            'instagram'=> $socialInstagram,
            'linkedin' => $socialLinkedin,
            'facebook' => $socialFacebook,
            'tiktok'   => $socialTiktok,
            'youtube'  => $socialYoutube,
        ];

        return [
            'siteTitle'        => $siteTitle,
            'siteLogo'         => $siteLogo,
            'siteLogoUrl'      => $siteLogoUrl,
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
            'whatsappLink'     => $whatsappLink,
            'contactPhone'     => $contactPhone,
            'contactEmail'     => $contactEmail,
            'socialLinks'      => $socialLinks,
            'organizationSchema' => $organizationSchema,
        ];
    }
}
