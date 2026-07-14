<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function templates()
    {
        return $this->hasMany(DocumentTemplate::class, 'category_id');
    }
}
