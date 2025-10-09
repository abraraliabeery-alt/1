<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'title' => 'تشطيب فيلا حديثة — حي الياسمين',
                'client' => 'أسرة م.',
                'city' => 'الرياض',
                'category' => 'فيلا',
                'description' => 'تشطيبات داخلية وخارجية متكاملة مع إضاءة ذكية ومناخ متعدد المناطق.',
                'status' => 'completed',
                'is_featured' => true,
                'cover_image' => '/assets/og-image.svg',
                'gallery' => [],
            ],
            [
                'title' => 'تهيئة مكتب شركة تقنية — العقيق',
                'client' => 'شركة تقنية س.',
                'city' => 'الرياض',
                'category' => 'مكتب',
                'description' => 'شبكات بيانات وWi‑Fi Mesh وغرف اجتماعات ذكية مع جداول حجز.',
                'status' => 'completed',
                'is_featured' => true,
                'cover_image' => '/assets/og-image.svg',
                'gallery' => [],
            ],
            [
                'title' => 'أعمال MEP لمجمع تجاري',
                'client' => 'تطوير عقاري',
                'city' => 'جدة',
                'category' => 'تجاري',
                'description' => 'كهرباء وإنارة، تكييف مركزي، وشبكات مياه وصرف وفق المواصفات.',
                'status' => 'completed',
                'is_featured' => false,
                'cover_image' => '/assets/og-image.svg',
                'gallery' => [],
            ],
        ];

        foreach ($samples as $s) {
            Project::updateOrCreate(
                ['slug' => Str::slug($s['title'])],
                array_merge($s, ['slug' => Str::slug($s['title'])])
            );
        }
    }
}
