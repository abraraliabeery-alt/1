<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'icon', 'cover_image',
        'type', 'is_featured', 'sort_order', 'status'
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

    public function getStatusLabelAttribute(): ?string
    {
        if (!$this->status) {
            return null;
        }

        $map = [
            'published' => 'منشور',
            'draft' => 'مسودة',
            'archived' => 'مؤرشف',
            'pending' => 'قيد المراجعة',
        ];

        $key = strtolower((string) $this->status);
        return $map[$key] ?? (string) $this->status;
    }

    public function getTypeLabelAttribute(): ?string
    {
        if (!$this->type) {
            return null;
        }

        $map = [
            1 => 'خدمات الصفحة الرئيسية',
            2 => 'خدمات المقاولات',
        ];

        $key = (int) $this->type;
        return $map[$key] ?? (string) $this->type;
    }
}
