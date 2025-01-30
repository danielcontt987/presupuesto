<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashCut extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salebox_id',
        'real_mount',
        'current_mount',
        'difference',
        'little_box',
        'observations',
        'date_opening',
        'date_cute', 
        'folio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salebox()
    {
        return $this->belongsTo(Salebox::class);
    }
}
