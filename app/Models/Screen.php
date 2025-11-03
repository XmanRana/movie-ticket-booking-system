<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = ['theatre_id', 'screen_name', 'total_seats', 'base_price'];

    // One screen belongs to one theatre
    public function theatre()
    {
        return $this->belongsTo(Theatre::class);
    }

    // One screen has many shows
    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    // One screen has many seats
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
