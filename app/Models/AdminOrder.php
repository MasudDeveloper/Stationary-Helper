<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'shopkeeper_id',
        'order_details',
        'amount',
        'status',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function shopkeeper()
    {
        return $this->belongsTo(User::class, 'shopkeeper_id');
    }
}
