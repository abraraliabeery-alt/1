<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::setValues([
            'hero_title' => 'خدمات المقاولات',
            'hero_subtitle' => 'إبداعية واحترافية',
            'hero_description' => 'نقدم حلول مقاولات متكاملة تشمل البناء، التشطيب، الصيانة، وإدارة المشاريع بأعلى معايير الجودة والسلامة.',
            'hero_image' => '/assets/hero-smart-home.jpg',

            'about_title' => 'من نحن',
            'about_description' => 'نقدم خدمات متكاملة تجمع بين الخبرة والاحترافية والالتزام بأعلى معايير الجودة.',
            'about_image' => '/assets/smart-office.jpg',

            'stats_1_value' => '+850',
            'stats_1_label' => 'مشروع منجز',
            'stats_2_value' => '+2500',
            'stats_2_label' => 'عميل راضٍ',
            'stats_3_value' => '+120',
            'stats_3_label' => 'موظف محترف',
            'stats_4_value' => '+15',
            'stats_4_label' => 'سنة خبرة',

            'show_testimonials' => '1',
            'show_ip_pbx' => '1',
            'show_servers' => '1',
            'show_fingerprint' => '1',
            'show_portfolio' => '1',
            'show_faqs' => '1',

            'contact_phone' => '0550000000',
            'contact_email' => 'info@example.com',
            'whatsapp_link' => 'https://wa.me/966550000000',
        ]);
    }
}
