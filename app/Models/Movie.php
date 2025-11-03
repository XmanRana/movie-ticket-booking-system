<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'description', 'genre', 'language', 
        'duration', 'rating', 'poster_url', 'release_date'
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    // One movie has many shows
    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    // Helper method
    public function isActive()
    {
        return $this->release_date <= now();
    }
}
