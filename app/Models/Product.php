<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'folio_personality',
        'name',
        'barcode',
        'description',
        'is_service',
        'price_shop',
        'price_s_shop',
        'price_sale',
        'price_s_sale',
        'iva',
        'business_id',
        'user_id',
    ];
}
