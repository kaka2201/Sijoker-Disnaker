<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletionReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'reason',
        'status',
    ];

    // Define the relationship with the User model (the participant)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the User model (the admin who deleted the participant)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
