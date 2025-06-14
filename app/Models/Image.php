<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'meal_id',
        'image'
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
