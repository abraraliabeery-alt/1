<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoqItem extends Model
{
    protected $fillable = [
        'boq_id','item_code','item_name','spec','unit','quantity','unit_price','total_line','sort_order'
    ];

    public function header(): BelongsTo { return $this->belongsTo(BoqHeader::class, 'boq_id'); }
}
