<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'شريك 1',
                'website_url' => 'https://example.com',
                'logo' => '/assets/top.png',
                'sort_order' => 10,
                'status' => 'published',
            ],
            [
                'name' => 'شريك 2',
                'website_url' => 'https://example.com',
                'logo' => '/assets/top.png',
                'sort_order' => 20,
                'status' => 'published',
            ],
            [
                'name' => 'شريك 3',
                'website_url' => null,
                'logo' => '/assets/top.png',
                'sort_order' => 30,
                'status' => 'published',
            ],
        ];

        foreach ($items as $i) {
            $slug = Str::slug($i['name']);
            Partner::updateOrCreate(
                ['slug' => $slug],
                array_merge($i, ['slug' => $slug])
            );
        }
    }
}
