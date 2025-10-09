<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'title' => 'واجهة فيلا مع إضاءة معمارية',
                'caption' => 'تنسيق واجهة ليلية بإضاءة ذكية موفرة',
                'category' => 'فيلا',
                'city' => 'الرياض',
                'image_path' => '/assets/og-image.svg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'غرفة اجتماعات ذكية',
                'caption' => 'تحكم بالمشاهد والحجوزات',
                'category' => 'مكتب',
                'city' => 'جدة',
                'image_path' => '/assets/og-image.svg',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'ردهة متجر تجزئة',
                'caption' => 'إضاءة عرض وتكامل أمني',
                'category' => 'تجاري',
                'city' => 'الدمام',
                'image_path' => '/assets/og-image.svg',
                'is_featured' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($samples as $s) {
            $slug = Str::slug($s['title']);
            GalleryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($s, ['slug' => $slug])
            );
        }
    }
}
