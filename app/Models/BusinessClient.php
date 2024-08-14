<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'client_id',
        'status',
        'iscredit',
        'unit_time_credit',
        'days_credit',
        'client_number',
        'limit_credit',
    ];
}
