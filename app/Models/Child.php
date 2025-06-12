<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'age',
        'gender',
        'image',
        'state_health',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class,'_child__meal');
    }
}
