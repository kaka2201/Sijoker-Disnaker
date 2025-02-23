<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'questioner_id',
        'title',
        'responsible_id',
        'likes',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(ComplaintDetail::class);
    }

    public function questioner()
    {
        return $this->belongsTo(User::class, 'questioner_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
