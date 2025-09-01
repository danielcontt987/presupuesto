<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectColums extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_detail_id',
        'name',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function details()
    {
        return $this->hasMany(ProjectDetail::class, 'project_colums_id');
    }

    public function cards()
    {
        return $this->hasMany(ProjectDetail::class, 'project_colums_id');
    }
}
