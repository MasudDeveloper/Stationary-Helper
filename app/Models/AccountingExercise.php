<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingExercise extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'title', 'stimulus', 'answer_schema'];

    protected $casts = [
        'answer_schema' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(AccountingLesson::class, 'lesson_id');
    }

    public function submissions()
    {
        return $this->hasMany(AccountingStudentSubmission::class, 'exercise_id');
    }
}
