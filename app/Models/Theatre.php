<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theatre extends Model
{
    protected $fillable = [
        'name', 'city', 'address', 'phone', 'latitude', 'longitude'
    ];

    // One theatre has many screens
    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    // Get all shows in this theatre through screens
    public function shows()
    {
        return $this->hasManyThrough(Show::class, Screen::class);
    }
}
