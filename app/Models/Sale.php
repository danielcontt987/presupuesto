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
        'cash',
        'transfer',
        'card',
        'check',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function salebox()
    {
        return $this->belongsTo(Salebox::class);
    }

    public function cashcut()
    {
        return $this->belongsTo(CashCut::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
