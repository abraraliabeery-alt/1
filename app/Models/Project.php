<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'client', 'city', 'category', 'description',
        'cover_image', 'gallery', 'status', 'started_at', 'finished_at', 'is_featured'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function getCoverImageUrlAttribute(): ?string
    {
        $v = $this->cover_image;
        if (!$v) {
            return null;
        }
        if (Str::startsWith($v, ['http://','https://'])) {
            return $v;
        }
        return url(ltrim($v, '/'));
    }
}
