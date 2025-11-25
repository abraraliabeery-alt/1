<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    protected $fillable = [
        'tender_id','file_id','category','label','notes','page_start','page_end','version_no','is_current','display_order'
    ];

    public function tender(): BelongsTo { return $this->belongsTo(Tender::class); }
    public function file(): BelongsTo { return $this->belongsTo(TenderFile::class, 'file_id'); }
}
