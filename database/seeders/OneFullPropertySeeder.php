<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Illuminate\Support\Str;

class OneFullPropertySeeder extends Seeder
{
    public function run(): void
    {
        $title = 'فيلا فاخرة مع مسبح وحديقة';
        $slug  = Str::slug($title.'-'.now()->format('Ymd-His'));

        // Avoid duplicate on re-run
        if (Property::where('slug', $slug)->exists()) {
            return;
        }

        Property::create([
            'title'        => $title,
            'slug'         => $slug,
            'city'         => 'الرياض',
            'district'     => 'الياسمين',
            'type'         => 'villa',
            'price'        => 2450000,
            'area'         => 520,
            'bedrooms'     => 5,
            'bathrooms'    => 5,
            'status'       => 'جاهز للسكن',
            'is_featured'  => true,
            // Keep cover_image null to use elegant fallback image; you can later attach a stored image path like "properties/covers/cover.jpg"
            'cover_image'  => null,
            'gallery'      => [
                'https://images.unsplash.com/photo-1505692794403-34b20be2a9bf?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1501183638710-841dd1904471?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1484154218962-a197022b5858?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1460317442991-0ec209397118?q=80&w=1200&auto=format&fit=crop'
            ],
            'amenities'    => ['موقف سيارة','مصعد','تكييف مركزي','مطبخ راكب','قريب من الخدمات','شرفة','حديقة'],
            'description'  => "فيلا راقية بتشطيب فاخر، موقع مميز بحي الياسمين، تتكون من مجلس وصالة واسعة ومطبخ راكب وغرف نوم ماستر وحديقة خلفية مع مسبح.",
            'location_url' => 'https://www.google.com/maps?q=24.8136,46.6653',
            'video_url'    => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'video_path'   => null,
        ]);
    }
}
