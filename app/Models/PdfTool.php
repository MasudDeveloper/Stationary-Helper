<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfTool extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'gradient_class',
        'route_name',
        'is_hot',
        'is_active',
        'order'
    ];
}
