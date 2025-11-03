<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'show_id', 'number_of_seats', 
        'total_amount', 'payment_status', 'booking_reference', 
        'booking_date', 'show_date'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'show_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    // One booking has many tickets (one per seat)
    public function tickets()
    {
        return $this->hasMany(TicketBooking::class);
    }

    // Get array of seat numbers
    public function getSeatNumbers()
    {
        return $this->tickets()
            ->with('seat')
            ->get()
            ->pluck('seat.seat_number')
            ->toArray();
    }
}
