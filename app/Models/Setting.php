<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key','value'];
    public $timestamps = false;

    protected $table = 'settings';

    public static function getValue(string $key, $default = null)
    {
        return Cache::rememberForever('setting:'.$key, function() use ($key, $default){
            $row = static::query()->where('key',$key)->first();
            return $row ? $row->value : $default;
        });
    }

    public static function setValues(array $keyValues): void
    {
        foreach ($keyValues as $key => $value) {
            static::updateOrCreate(['key'=>$key], ['value'=> (string) ($value ?? '')]);
            Cache::forget('setting:'.$key);
        }
    }
}
