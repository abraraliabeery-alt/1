<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','email','phone',
        'property_title','city','district','type','price','area','description',
        'files','status','assigned_employee_id','updated_by'
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
