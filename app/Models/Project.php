<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'name_client',
        'status',
        'business_id',
    ];

    public function details()
    {
        return $this->hasMany(ProjectDetail::class);
    }
    public function columns()
    {
        return $this->hasMany(ProjectColums::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
