<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'command_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'status',
        'notes',
    ];
}
