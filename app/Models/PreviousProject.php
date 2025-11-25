<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreviousProject extends Model
{
    protected $fillable = [
        'tender_id','project_name','client_name','year','team_members','cost','description','evidence_file_id'
    ];

    public function tender(): BelongsTo { return $this->belongsTo(Tender::class); }
    public function evidenceFile(): BelongsTo { return $this->belongsTo(TenderFile::class, 'evidence_file_id'); }
}
