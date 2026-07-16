<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    protected $fillable = [
        'user_id',
        'person_name',
        'type',
        'amount',
        'purpose',
        'due_date',
        'is_paid',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
