<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = ['name','sector','city','contact_ref'];

    public function tenders(): HasMany
    {
        return $this->hasMany(Tender::class);
    }
}
