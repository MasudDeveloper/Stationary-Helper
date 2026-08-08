<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category_id',
        'language',
        'description',
        'content',
        'total_fields',
        'fields_data',
        'is_active',
        'credit_cost',
        'page_size',
        'page_orientation',
        'margin_top_first',
        'margin_top',
        'margin_bottom',
        'margin_left',
        'margin_right',
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
