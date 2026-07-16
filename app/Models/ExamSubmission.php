<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSubmission extends Model
{
    protected $fillable = [
        'exam_participant_id',
        'exam_id',
        'answers',
        'total_score',
        'status',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function participant()
    {
        return $this->belongsTo(ExamParticipant::class, 'exam_participant_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
