<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_id',
        'reason',
        'status',
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan training
    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
