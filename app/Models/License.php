<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    protected $fillable = [
        'tender_id','license_type','issuing_authority','license_no','issue_date','expiry_date','verification_url','file_id','notes'
    ];

    protected $casts = [ 'issue_date'=>'date','expiry_date'=>'date' ];

    public function tender(): BelongsTo { return $this->belongsTo(Tender::class); }
    public function file(): BelongsTo { return $this->belongsTo(TenderFile::class, 'file_id'); }
}
