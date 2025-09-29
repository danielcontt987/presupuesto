<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'module_id',
    ];

    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }
}
