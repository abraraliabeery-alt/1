<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenderFile extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'storage_path','original_name','mime_type','size_bytes','sha256','pages_count','ocr_status','uploaded_by'
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(FileTextPage::class, 'file_id');
    }
}
