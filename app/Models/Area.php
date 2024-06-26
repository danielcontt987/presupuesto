<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'business_id',
        'folio',
    ];

    public function areaUsers()
    {
        return $this->hasMany(AreaUser::class, 'area_id');
    }

    public function permissions(){
        return $this->hasMany(Permission::class);
    }
}
