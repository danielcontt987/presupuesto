<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;
    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total_amount',
        'notes',
        'chef_id',
    ];
    public function details()
    {
        return $this->hasMany(CommandDetail::class, 'command_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
}
