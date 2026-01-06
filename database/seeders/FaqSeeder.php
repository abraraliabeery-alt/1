<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'question' => 'كم يستغرق تنفيذ المشروع؟',
                'answer' => 'يختلف حسب حجم العمل ونطاقه، لكننا نقدم لك جدولاً زمنياً واضحاً قبل البدء.',
                'status' => 'published',
                'sort_order' => 10,
            ],
            [
                'question' => 'هل تقدمون ضمان على الأعمال؟',
                'answer' => 'نعم، يوجد ضمان حسب نوع الخدمة وبنود العقد، مع متابعة ما بعد التسليم.',
                'status' => 'published',
                'sort_order' => 20,
            ],
            [
                'question' => 'هل يمكن طلب معاينة قبل الاتفاق؟',
                'answer' => 'نعم، يمكن طلب معاينة وتقييم مبدئي للموقع وتحديد المتطلبات بدقة.',
                'status' => 'published',
                'sort_order' => 30,
            ],
            [
                'question' => 'كيف يتم التسعير؟',
                'answer' => 'التسعير يعتمد على المواد، المساحة، ونطاق الأعمال. نرسل عرض سعر تفصيلي ومكتوب.',
                'status' => 'published',
                'sort_order' => 40,
            ],
        ];

        foreach ($items as $i) {
            Faq::updateOrCreate(
                ['question' => $i['question']],
                $i
            );
        }
    }
}
