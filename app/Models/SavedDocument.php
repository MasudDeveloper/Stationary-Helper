<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedDocument extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'type',
        'title',
        'form_data',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
