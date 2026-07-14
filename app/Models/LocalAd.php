<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalAd extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'target_url',
        'slot',
        'is_active',
    ];
}
