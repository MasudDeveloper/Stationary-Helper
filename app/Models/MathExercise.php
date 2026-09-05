<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathExercise extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'title', 'question', 'options', 'correct_answer', 'explanation'];

    protected $casts = [
        'options' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(MathLesson::class, 'lesson_id');
    }
}
