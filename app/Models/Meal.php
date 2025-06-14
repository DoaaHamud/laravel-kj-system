<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category'

    ];

    public function children()
    {
        return $this->belongsToMany(Child::class,'_child__meal');
    }

     public function images()
    {
        return $this->hasMany(Image::class);
    }
}
