<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
