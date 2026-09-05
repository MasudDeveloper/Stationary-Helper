<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_no',
        'level_name',
        'category',
        'rule',
        'formula',
        'recognition',
        'step_1',
        'step_2',
        'step_3',
        'example',
        'common_mistake',
        'exam_answer_pattern',
        'is_active'
    ];

    public function exercises()
    {
        return $this->hasMany(GrammarExercise::class, 'lesson_id');
    }

    public function submissions()
    {
        return $this->hasMany(GrammarSubmission::class, 'lesson_id');
    }
}
