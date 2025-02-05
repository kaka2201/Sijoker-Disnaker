<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ktp', 'kk', 'ijazah', 'ak1', 
        'ktp_status', 'kk_status', 'ijazah_status', 'ak1_status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke pengguna atau profil
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id'); // Sesuaikan jika menggunakan profile_id
    }
    
}
