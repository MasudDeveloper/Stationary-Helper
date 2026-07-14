<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiTemplate extends Model
{
    protected $fillable = [
        'title',
        'category',
        'thumbnail_path',
        'prompt',
        'inputs_schema',
        'overlay_settings',
        'is_premium',
        'credits_cost',
    ];

    protected $casts = [
        'inputs_schema' => 'array',
        'overlay_settings' => 'array',
        'is_premium' => 'boolean',
    ];
}
