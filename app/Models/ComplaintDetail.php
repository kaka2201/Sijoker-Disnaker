<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintDetail extends Model
{
    protected $fillable = [
        'complaint_id',
        'question',
        'answer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
