<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MathStudentSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lesson_id', 'score', 'is_completed', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(MathLesson::class, 'lesson_id');
    }
}
