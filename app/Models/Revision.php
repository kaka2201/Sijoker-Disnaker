<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'revisi_message'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
