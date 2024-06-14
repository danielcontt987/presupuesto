<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Colony extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'zipcode',
        'settlement',
        'settlement_type',
        'municipality',
        'state',
        'zone',
    ];
}
