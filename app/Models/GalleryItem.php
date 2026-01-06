<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'caption', 'category', 'city', 'image_path', 'taken_at', 'is_featured', 'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'taken_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        $v = $this->image_path;
        if (!$v) {
            return null;
        }
        if (Str::startsWith($v, ['http://','https://'])) {
            return $v;
        }
        return url(ltrim($v, '/'));
    }
}
