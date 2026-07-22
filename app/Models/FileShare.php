<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'original_name',
        'pin_code',
        'file_size',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
