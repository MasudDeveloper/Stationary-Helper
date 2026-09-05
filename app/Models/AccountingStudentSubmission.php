<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingStudentSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'exercise_id', 'submitted_answers', 'is_correct', 'score', 'feedback'];

    protected $casts = [
        'submitted_answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(AccountingExercise::class, 'exercise_id');
    }
}
