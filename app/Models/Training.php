<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trainings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'capacity',
        'location',
        'image', // Jika ada gambar, tambahkan ke mass assignable
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi hasManyThrough untuk mendapatkan peserta pelatihan (User) melalui Registration.
     */
    public function participants()
    {
        return $this->hasManyThrough(User::class, Registration::class, 'training_id', 'id', 'id', 'user_id');
    }

    /**
     * Relasi hasMany ke model Registration, untuk mencatat siapa saja yang mendaftar.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'training_id');
    }
}
