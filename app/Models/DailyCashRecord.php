<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyCashRecord extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'note_1000',
        'note_500',
        'note_200',
        'note_100',
        'note_50',
        'note_20',
        'note_10',
        'note_5',
        'note_2',
        'note_1',
        'total_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
