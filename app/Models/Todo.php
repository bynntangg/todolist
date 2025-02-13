<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'prioritas', 'tanggal_dibuat', 'tanggal_diceklis'];
    
    protected $casts = [
        'tanggal_diceklis' => 'datetime',
    ];
}
