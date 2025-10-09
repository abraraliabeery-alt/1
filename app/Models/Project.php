<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
