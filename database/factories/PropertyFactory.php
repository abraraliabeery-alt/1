<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake('ar_SA')->randomElement([
            'شقة عصرية','فيلا فاخرة','أرض سكنية','شقة واسعة','شقة ببرج حديث','مكتب تجاري','محل تجاري'
        ]);
        $type = fake()->randomElement(['apartment','villa','land','office','shop']);
        $city = fake('ar_SA')->randomElement(['الرياض','جدة','الدمام','الخبر','مكة']);
        $district = fake('ar_SA')->randomElement(['الياسمين','العقيق','النرجس','السلام','الخالدية']);
        $price = fake()->numberBetween(200000, 5000000);
        $gallery = [
            'https://images.unsplash.com/photo-1505692794403-34b20be2a9bf?q=80&w=1200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1501183638710-841dd1904471?q=80&w=1200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1484154218962-a197022b5858?q=80&w=1200&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1460317442991-0ec209397118?q=80&w=1200&auto=format&fit=crop',
        ];
        $amenities = fake('ar_SA')->randomElements([
            'موقف سيارة','مصعد','تكييف مركزي','مطبخ راكب','قريب من الخدمات','شرفة','خدمة حراسة','حديقة','ملعب أطفال'
        ], fake()->numberBetween(4,7));
        return [
            'title' => $title,
            'slug' => Str::slug($title.'-'.fake()->unique()->numberBetween(1000,9999)),
            'city' => $city,
            'district' => $district,
            'type' => $type,
            'price' => $price,
            'area' => fake()->numberBetween(80, 1200),
            'bedrooms' => fake()->numberBetween(1, 6),
            'bathrooms' => fake()->numberBetween(1, 5),
            'status' => fake()->randomElement(['جاهز للسكن','تحت الإنشاء']),
            'is_featured' => fake()->boolean(30),
            'cover_image' => null,
            'gallery' => $gallery,
            'amenities' => $amenities,
            'description' => 'وصف مختصر للعقار مناسب للعرض ضمن النتائج.',
            'location_url' => 'https://www.google.com/maps?q=24.7136,46.6753',
            'video_url' => fake()->boolean(40) ? 'https://www.youtube.com/embed/dQw4w9WgXcQ' : null,
            'video_path' => null,
        ];
    }
}
