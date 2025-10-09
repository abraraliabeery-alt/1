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
            'gallery' => [],
            'description' => 'وصف مختصر للعقار مناسب للعرض ضمن النتائج.',
            'location_url' => null,
            'video_url' => null,
            'video_path' => null,
        ];
    }
}
