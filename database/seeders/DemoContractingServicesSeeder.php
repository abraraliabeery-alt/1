<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoContractingServicesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'تنفيذ الهيكل الإنشائي',
                'excerpt' => 'تنفيذ أعمال الحفر والقواعد والأعمدة والأسقف وفق المخططات وبإشراف هندسي.',
                'body' => 'نقدّم تنفيذ الهيكل الإنشائي للمباني السكنية والتجارية بجودة عالية، مع الالتزام بالمواصفات الفنية ومعايير السلامة، وتوثيق مراحل التنفيذ حتى الاستلام.',
                'icon' => 'bi bi-building',
                'cover_image' => '/assets/smart-office.jpg',
                'sort_order' => 10,
                'type' => 2,
            ],
            [
                'title' => 'التشطيبات الداخلية والخارجية',
                'excerpt' => 'دهانات، أرضيات، جبس، واجهات، عزل، أعمال السباكة والكهرباء بتنسيق كامل.',
                'body' => 'تشطيبات متكاملة تبدأ من المعاينة واختيار المواد وحتى التنفيذ والتسليم، مع ضمان جودة التشطيب وتناسق التفاصيل وتوافق الأعمال (ميكانيكا/كهرباء/سباكة).',
                'icon' => 'bi bi-brush',
                'cover_image' => '/assets/hero-smart-home.jpg',
                'sort_order' => 20,
                'type' => 2,
            ],
            [
                'title' => 'الصيانة والترميم',
                'excerpt' => 'معالجة تشققات، ترميم واجهات، إصلاحات سباكة وكهرباء وتحديثات للمنشآت.',
                'body' => 'خدمات صيانة دورية وطارئة للمنازل والمنشآت، تشمل الكشف، تحديد الأسباب الجذرية، تنفيذ المعالجة، وتقديم توصيات لرفع كفاءة المبنى وتقليل الأعطال.',
                'icon' => 'bi bi-tools',
                'cover_image' => '/assets/smart-home.jpg',
                'sort_order' => 30,
                'type' => 2,
            ],
            [
                'title' => 'إدارة المشاريع والإشراف',
                'excerpt' => 'متابعة جداول التنفيذ والتكاليف، تنسيق المقاولين، تقارير دورية وجودة واستلام.',
                'body' => 'إدارة مشروعك من البداية للنهاية: خطة زمنية، متابعة الموارد، ضبط الجودة، تقارير أسبوعية، واستلام مرحلي لضمان الالتزام بالوقت والتكلفة والمواصفات.',
                'icon' => 'bi bi-clipboard-check',
                'cover_image' => '/assets/smart-office.jpg',
                'sort_order' => 40,
                'type' => 2,
            ],
        ];

        foreach ($items as $data) {
            $slug = Str::slug($data['title']);

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'slug' => $slug,
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'icon' => $data['icon'],
                    'cover_image' => $data['cover_image'],
                    'type' => $data['type'],
                    'is_featured' => false,
                    'sort_order' => $data['sort_order'],
                    'status' => 'published',
                ]
            );
        }
    }
}
