<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
