<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferItem extends Model
{
    protected $fillable = [
        'financial_offer_id','name','description','qty','unit','unit_price','vat','total','order_index'
    ];

    public function financialOffer(): BelongsTo
    {
        return $this->belongsTo(FinancialOffer::class);
    }
}
