<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Tambahkan atribut yang sesuai dengan tabel profile
    protected $table = 'profile'; // Nama tabel di database
    protected $fillable = [
        'user_id', 'name', 'nik', 'ttl', 'gender', 'kecamatan', 'desa', 'jalan', 'pendidikan', 'nomor', 'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');  // Sesuaikan jika menggunakan profile_id
    }
    
}
