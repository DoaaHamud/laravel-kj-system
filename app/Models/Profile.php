<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'bio',
        'date_of_birth',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
