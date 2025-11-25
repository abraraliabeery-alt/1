<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tender extends Model
{
    protected $fillable = [
        'title','client_name','competition_no','submission_date','notes','status','created_by','pdf_path',
        'client_id','tender_no','validity_days','total_before_vat','vat_amount','total_with_vat',
        'cover_image','cover_image_url'
    ];

    protected $casts = [
        'submission_date' => 'date',
        'total_before_vat' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_with_vat' => 'decimal:2',
    ];

    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
    public function boqHeaders(): HasMany { return $this->hasMany(BoqHeader::class); }
    public function attachments(): HasMany { return $this->hasMany(Attachment::class); }
    public function previousProjects(): HasMany { return $this->hasMany(PreviousProject::class); }
    public function licenses(): HasMany { return $this->hasMany(License::class); }
    public function certificates(): HasMany { return $this->hasMany(Certificate::class); }
    public function financialOffers(): HasMany { return $this->hasMany(FinancialOffer::class); }
}
