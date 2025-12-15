<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'city',
        'district',
        'type',
        'price',
        'area',
        'bedrooms',
        'bathrooms',
        'status',
        'is_featured',
        'cover_image',
        'gallery',
        'amenities',
        'description',
        'user_id',
        'location_url',
        'video_url',
        'video_path',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'gallery' => 'array',
        'amenities' => 'array',
        'price' => 'integer',
        'area' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        $v = $this->cover_image;
        if (!$v) {
            return null;
        }
        if (Str::startsWith($v, ['http://','https://'])) {
            return $v;
        }
        // Assume relative path under public (e.g. /uploads/properties/filename.jpg)
        return url(ltrim($v, '/'));
    }

    /**
     * Primary image used in cards and detail pages.
     */
    public function getPrimaryImageUrlAttribute(): ?string
    {
        // Prefer explicit cover image accessor when available
        $cover = $this->cover_image_url;
        if (!empty($cover)) {
            return $cover;
        }

        $gallery = $this->gallery_urls;
        if (!empty($gallery)) {
            return $gallery[0];
        }

        return null;
    }

    /**
     * Resolved gallery URLs with storage / external handling.
     */
    public function getGalleryUrlsAttribute(): array
    {
        $raw = is_array($this->gallery ?? null) ? $this->gallery : [];
        $urls = [];

        foreach ($raw as $img) {
            if (!$img) {
                continue;
            }
            if (Str::startsWith($img, ['http://','https://'])) {
                $urls[] = $img;
                continue;
            }
            $urls[] = url(ltrim($img, '/'));
        }

        return $urls;
    }

    // Derived attributes for cleaner Blade templates
    public function getAddressAttribute(): string
    {
        $city = (string)($this->city ?? '');
        $district = (string)($this->district ?? '');
        return trim($city . ($district ? ' - ' . $district : ''));
    }

    public function getTypeLabelAttribute(): ?string
    {
        if (!$this->type) return null;
        $map = [
            'warehouse' => 'مستودع',
            'apartment' => 'شقة',
            'villa' => 'فيلا',
            'land' => 'أرض',
            'office' => 'مكتب',
            'house' => 'بيت',
            'shop' => 'محل',
        ];
        $key = strtolower((string)$this->type);
        return $map[$key] ?? (string)$this->type;
    }

    public function getInterfaceLabelAttribute(): ?string
    {
        if (!$this->interface) return null;
        $map = [
            'n' => 'شمال', 'north' => 'شمال',
            'e' => 'شرق',  'east' => 'شرق',
            's' => 'جنوب', 'south' => 'جنوب',
            'w' => 'غرب',  'west' => 'غرب',
        ];
        $key = strtolower((string)$this->interface);
        return $map[$key] ?? (string)$this->interface;
    }

    public function getFurnishedLabelAttribute(): ?string
    {
        if (!isset($this->attributes['furnished'])) return null;
        $v = strtolower((string)$this->attributes['furnished']);
        return in_array($v, ['yes','true','1','furnished','مؤثث'], true) ? 'مؤثث' : 'غير مؤثث';
    }

    /**
     * Normalized amenities list for display.
     */
    public function getAmenitiesListAttribute(): array
    {
        $raw = is_array($this->amenities ?? null)
            ? $this->amenities
            : (is_array($this->features ?? null) ? $this->features : []);

        // نفس قائمة المزايا المستخدمة في لوحة التحكم (Admin\PropertyAdminController)
        // نستخدمها هنا لتحويل المفاتيح الإنجليزية إلى تسميات عربية عند العرض فقط.
        $labels = [
            'parking' => 'موقف سيارة',
            'elevator' => 'مصعد',
            'central_ac' => 'تكييف مركزي',
            'split_ac' => 'مكيفات سبليت',
            'furnished' => 'مفروش',
            'balcony' => 'بلكونة',
            'maid_room' => 'غرفة خادمة',
            'driver_room' => 'غرفة سائق',
            'pool' => 'مسبح',
            'garden' => 'حديقة',
            'roof' => 'سطح',
            'basement' => 'قبو',
            'security' => 'حراسة',
            'cameras' => 'كاميرات',
            'smart_home' => 'منزل ذكي',
            'solar' => 'طاقة شمسية',
            'fireplace' => 'مدفأة',
            'laundry_room' => 'غرفة غسيل',
            'storage' => 'مستودع',
            'playground' => 'ملعب',
            'gym' => 'نادي رياضي',
            'clubhouse' => 'نادي اجتماعي',
            'sea_view' => 'إطلالة بحرية',
            'corner' => 'زاوية',
            'two_streets' => 'شارعين',
            'near_metro' => 'قريب مترو',
            'near_mall' => 'قريب مول',
            'schools' => 'قريب مدارس',
            'hospitals' => 'قريب مستشفيات',
            'mosques' => 'قريب مساجد',
            'supermarket' => 'قريب سوبرماركت',
            'private_entrance' => 'مدخل خاص',
            'duplex' => 'دوبلكس',
            'annex' => 'ملحق',
            'new_build' => 'بناء جديد',
            'renovated' => 'مجدّد',
            'open_kitchen' => 'مطبخ مفتوح',
            'closed_kitchen' => 'مطبخ مغلق',
            'marble_floor' => 'أرضيات رخام',
            'ceramic_floor' => 'أرضيات سيراميك',
            'wooden_floor' => 'أرضيات خشب',
            'water_well' => 'بئر ماء',
            'electricity' => 'كهرباء',
            'asphalt' => 'سفلت',
            'deed' => 'صك',
            'mortgage_ok' => 'قبول رهن',
            'installments' => 'أقساط',
            'negotiable' => 'قابل للتفاوض',
        ];

        $out = [];
        foreach ($raw as $am) {
            if (empty($am)) {
                continue;
            }

            // في حال كانت القيمة مصفوفة قديمة تحوي اسمًا
            if (is_array($am)) {
                $name = $am['name'] ?? null;
                if (!empty($name)) {
                    $out[] = $name;
                }
                continue;
            }

            $key = strtolower((string)$am);
            $out[] = $labels[$key] ?? (string)$am;
        }

        return array_values(array_filter($out, fn($v) => $v !== ''));
    }

    /**
     * Whether the location URL is embeddable in an iframe (Google Maps, etc.).
     */
    public function getIsLocationEmbeddableAttribute(): bool
    {
        $url = (string) ($this->location_url ?? '');
        if ($url === '') {
            return false;
        }

        return Str::contains($url, ['google.com/maps','maps.google','goo.gl/maps','maps.app.goo']);
    }

    // Helper to fetch similar properties
    public function similar(int $limit = 6, float $priceRange = 0.2)
    {
        return self::query()
            ->when($this->city, fn($q)=>$q->where('city', $this->city))
            ->when($this->type, fn($q)=>$q->where('type', $this->type))
            ->when(!empty($this->price), function($q){
                $p = (int)$this->price; $low = max(0, (int)floor($p * (1 - 0.2))); $high = (int)ceil($p * (1 + 0.2));
                $q->whereBetween('price', [$low, $high]);
            })
            ->where('id', '!=', $this->id)
            ->latest('id')
            ->limit($limit)
            ->get();
    }
}
