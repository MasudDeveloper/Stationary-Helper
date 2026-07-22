<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language',
        'format',
        'design_name',
        'content',
        'total_fields',
        'fields_data',
        'credit_cost',
        'is_active',
    ];
}
