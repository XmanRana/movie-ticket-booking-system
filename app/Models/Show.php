<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $fillable = ['movie_id', 'screen_id', 'show_time', 'ticket_price', 'show_type'];

    protected $casts = [
        'show_time' => 'datetime',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Get available seats count
    public function getAvailableSeatsCount()
    {
        $totalSeats = $this->screen->total_seats;
        $bookedCount = $this->bookings()
            ->where('payment_status', 'completed')
            ->sum('number_of_seats');
        
        return $totalSeats - $bookedCount;
    }

    // Get array of booked seat IDs
    public function getBookedSeatIds()
    {
        return $this->bookings()
            ->where('payment_status', 'completed')
            ->with('tickets')
            ->get()
            ->pluck('tickets.*.seat_id')
            ->flatten()
            ->unique()
            ->toArray();
    }

    // Check if show is in future
    public function isFuture()
    {
        return $this->show_time > now();
    }
}
