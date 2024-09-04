<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'inventory_id',
        'stock',
        'min',
        'max',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);    
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);    
    }
}