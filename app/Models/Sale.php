<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'folio',
        'client_id',
        'user_id',
        'salebox_id',
        'cashcut_id',
        'status',
        'status_ticket',
        'json_concept',
        'saledate',
        'total',
        'subtotal',
        'iva',
    ];
}
