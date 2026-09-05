<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathLesson extends Model
{
    use HasFactory;

    protected $fillable = ['chapter_no', 'title', 'description', 'is_active'];

    public function exercises()
    {
        return $this->hasMany(MathExercise::class, 'lesson_id');
    }
}
