<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    protected $table = 'ticket_bookings';
    protected $fillable = ['booking_id', 'seat_id', 'status'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
