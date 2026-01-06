<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'أحمد',
                'caption' => 'تعامل راقٍ وجودة تنفيذ ممتازة والتزام بالمواعيد.',
                'category' => 'testimonials',
                'city' => 'الرياض',
                'image_path' => '/assets/og-image.svg',
                'is_featured' => true,
                'sort_order' => 10,
            ],
            [
                'title' => 'سارة',
                'caption' => 'شغل احترافي من البداية للنهاية، وأنصح بالتعامل معهم.',
                'category' => 'testimonials',
                'city' => 'جدة',
                'image_path' => '/assets/og-image.svg',
                'is_featured' => true,
                'sort_order' => 20,
            ],
            [
                'title' => 'محمد',
                'caption' => 'متابعة ممتازة بعد التسليم ودعم سريع لأي استفسار.',
                'category' => 'testimonials',
                'city' => 'الدمام',
                'image_path' => '/assets/og-image.svg',
                'is_featured' => false,
                'sort_order' => 30,
            ],
        ];

        foreach ($items as $i) {
            $slug = Str::slug($i['title'].'-'.$i['sort_order']);
            GalleryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($i, ['slug' => $slug])
            );
        }
    }
}
