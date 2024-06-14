<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AreaUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'area_id',
        'user_id',
    ];

    public function area ()
    {
        return $this->belongsTo(Area::class);
    }
}
