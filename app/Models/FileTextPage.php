<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileTextPage extends Model
{
    protected $fillable = ['file_id','page_no','text','hash'];

    public function file(): BelongsTo { return $this->belongsTo(TenderFile::class, 'file_id'); }
}
