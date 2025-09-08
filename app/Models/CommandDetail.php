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

    public function command()
    {
        return $this->belongsTo(Command::class, 'command_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
