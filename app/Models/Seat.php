<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['screen_id', 'seat_number', 'row_number', 'column_number', 'seat_type'];

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    // Check if seat is booked for specific show
    public function isBookedForShow($showId)
    {
        return TicketBooking::whereHas('booking', function ($query) use ($showId) {
            $query->where('show_id', $showId)
                  ->where('payment_status', 'completed');
        })->where('seat_id', $this->id)->exists();
    }

    // Get price based on seat type
    public function getPrice($basePrice)
    {
        $multiplier = match($this->seat_type) {
            'premium' => 1.5,
            'recliner' => 2.0,
            default => 1.0
        };

        return $basePrice * $multiplier;
    }
}
