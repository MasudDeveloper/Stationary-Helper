<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'class',
        'type',
        'duration_minutes',
        'status',
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function participants()
    {
        return $this->hasMany(ExamParticipant::class);
    }

    public function submissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }
}
