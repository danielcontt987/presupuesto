<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $table = 'table_users'; // Ensure the table name matches the migration
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'is_active',
        'waiter_id',
    ];

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }
}
