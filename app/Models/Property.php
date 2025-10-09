<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    protected $fillable = [
        'slug', 'title', 'city', 'district', 'type', 'price', 'area', 'user_id',
        'bedrooms', 'bathrooms', 'status', 'is_featured', 'cover_image',
        'gallery', 'amenities', 'description', 'location_url', 'video_url', 'video_path'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'gallery' => 'array',
        'amenities' => 'array',
        'price' => 'integer',
        'area' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        // removed lat/lng in favor of a single location_url
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title.'-'.uniqid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getTypeLabelAttribute(): string
    {
        $map = [
            'apartment' => 'شقة',
            'villa' => 'فيلا',
            'land' => 'أرض',
            'office' => 'مكتب',
            'shop' => 'محل',
        ];
        return $map[$this->type] ?? (string) $this->type;
    }
}
