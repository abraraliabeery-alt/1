<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'website_url', 'logo', 'sort_order', 'status'
    ];

    public function getLogoUrlAttribute(): ?string
    {
        $v = $this->logo;
        if (!$v) {
            return null;
        }
        if (Str::startsWith($v, ['http://','https://'])) {
            return $v;
        }
        return url(ltrim($v, '/'));
    }
}
