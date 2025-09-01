<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_name',
        'task_description',
        'img',
        'due_date',
        'assigned_to',
        'project_colums_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function column()
    {
        return $this->belongsTo(ProjectColums::class, 'project_colums_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
