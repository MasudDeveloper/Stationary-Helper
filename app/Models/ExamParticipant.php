<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamParticipant extends Model
{
    protected $fillable = [
        'exam_id',
        'name',
        'roll_no',
        'phone',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function submissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }
}
