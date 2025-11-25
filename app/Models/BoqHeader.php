<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoqHeader extends Model
{
    protected $fillable = ['tender_id','currency','version_no','is_current','notes'];

    public function tender(): BelongsTo { return $this->belongsTo(Tender::class); }
    public function items(): HasMany { return $this->hasMany(BoqItem::class, 'boq_id')->orderBy('sort_order'); }
}
