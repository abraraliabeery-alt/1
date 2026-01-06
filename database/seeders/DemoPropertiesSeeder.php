<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Illuminate\Support\Str;

class DemoPropertiesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'أرض سكنية مميزة - 1', 'type' => 'land', 'city' => 'الرياض', 'district' => 'الياسمين', 'price' => 650000, 'area' => 500],
            ['title' => 'أرض سكنية مميزة - 2', 'type' => 'land', 'city' => 'الرياض', 'district' => 'العقيق', 'price' => 720000, 'area' => 600],
            ['title' => 'أرض سكنية مميزة - 3', 'type' => 'land', 'city' => 'جدة', 'district' => 'السلام', 'price' => 820000, 'area' => 550],
            ['title' => 'أرض سكنية مميزة - 4', 'type' => 'land', 'city' => 'الدمام', 'district' => 'الخالدية', 'price' => 590000, 'area' => 480],

            ['title' => 'شقة عصرية - 1', 'type' => 'apartment', 'city' => 'الرياض', 'district' => 'النرجس', 'price' => 980000, 'area' => 140, 'bedrooms' => 3, 'bathrooms' => 2],
            ['title' => 'شقة عصرية - 2', 'type' => 'apartment', 'city' => 'الرياض', 'district' => 'الياسمين', 'price' => 1050000, 'area' => 160, 'bedrooms' => 4, 'bathrooms' => 3],
            ['title' => 'شقة عصرية - 3', 'type' => 'apartment', 'city' => 'جدة', 'district' => 'السلام', 'price' => 880000, 'area' => 130, 'bedrooms' => 3, 'bathrooms' => 2],
            ['title' => 'شقة عصرية - 4', 'type' => 'apartment', 'city' => 'الخبر', 'district' => 'الخالدية', 'price' => 920000, 'area' => 150, 'bedrooms' => 3, 'bathrooms' => 2],
        ];

        foreach ($items as $data) {
            $slug = Str::slug($data['title']);

            Property::updateOrCreate(
                ['slug' => $slug],
                array_merge(
                    [
                        'title' => $data['title'],
                        'city' => $data['city'],
                        'district' => $data['district'] ?? null,
                        'type' => $data['type'],
                        'price' => $data['price'],
                        'area' => $data['area'] ?? null,
                        'bedrooms' => $data['bedrooms'] ?? null,
                        'bathrooms' => $data['bathrooms'] ?? null,
                        'status' => 'جاهز للسكن',
                        'is_featured' => false,
                        'cover_image' => null,
                        'gallery' => null,
                        'amenities' => null,
                        'description' => null,
                        'location_url' => null,
                        'video_url' => null,
                        'video_path' => null,
                        'user_id' => null,
                    ],
                    $data
                )
            );
        }
    }
}
