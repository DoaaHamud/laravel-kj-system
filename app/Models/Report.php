<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'child_id',
        'learn',
        'activities',
        'attitude',
        'mood'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
