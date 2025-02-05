<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemovalReason extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'admin_id', 'reason', 'status'];

    // Relation to the user being removed
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation to the admin performing the removal
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
