<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    // Get available seats for a show (ARRAYS CONCEPT)
    public function availableSeats($showId)
    {
        $show = Show::findOrFail($showId);
        $screen = $show->screen;

        // Get all seats
        $allSeats = $screen->seats()->get();

        // Get booked seat IDs
        $bookedSeatIds = collect($show->getBookedSeatIds());

        // Filter available seats (COLLECTIONS FILTERING)
        $availableSeats = $allSeats->filter(function ($seat) use ($bookedSeatIds) {
            return !$bookedSeatIds->contains($seat->id);
        })->values();

        return response()->json([
            'show_id' => $show->id,
            'movie' => $show->movie->title,
            'time' => $show->show_time,
            'price' => $show->ticket_price,
            'available_count' => $availableSeats->count(),
            'total_seats' => $allSeats->count(),
            'seats' => $availableSeats->map(function ($seat) {
                return [
                    'id' => $seat->id,
                    'number' => $seat->seat_number,
                    'type' => $seat->seat_type,
                    'row' => $seat->row_number,
                    'column' => $seat->column_number
                ];
            })
        ]);
    }
}
