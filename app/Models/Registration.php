<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Tentukan tabel jika nama tabel tidak mengikuti konvensi Laravel
    protected $table = 'registrations';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'training_id',
        'status', // Kolom tambahan untuk status registrasi
    ];

    // Relasi ke model User: Setiap registrasi terkait dengan satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Training: Setiap registrasi terkait dengan satu pelatihan (training)
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * Optional: Tambahkan method tambahan untuk menampilkan status dengan format yang lebih baik.
     * Contoh untuk menampilkan status dengan huruf kapital di awal kata.
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }
}
