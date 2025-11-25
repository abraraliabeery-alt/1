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
        if (!$v) return 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop';
        if (Str::startsWith($v, ['http://','https://'])) {
            return $v;
        }
        if (Storage::disk('public')->exists($v)) {
            return asset('storage/'.$v);
        }
        return 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop';
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
