<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Accessor untuk mendapatkan URL gambar profil user
     */
    public function getProfileImageUrlAttribute()
    {
        // Jika profile_image ada, maka return URL ke gambar di storage
        // Jika tidak ada, return URL gambar default
        return $this->profile_image 
            ? 'profile_pictures/' . $this->profile_image 
            : 'default-profile.jpg';  // Path untuk gambar default
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
    public function revisi()
    {
        return $this->hasOne(Revision::class, 'user_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function hasLiked(Complaint $complaint)
    {
        return $this->likes()->where('complaint_id', $complaint->id)->exists();
    }
}
