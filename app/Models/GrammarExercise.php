<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'question',
        'options',
        'correct_answer',
        'explanation'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function lesson()
    {
        return $this->belongsTo(GrammarLesson::class, 'lesson_id');
    }
}
