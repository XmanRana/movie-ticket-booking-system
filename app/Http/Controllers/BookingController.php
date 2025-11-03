<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Show;
use App\Models\TicketBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // Create new booking (LOOPS CONCEPT)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'show_id' => 'required|exists:shows,id',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id'
        ]);

        $show = Show::findOrFail($validated['show_id']);
        $seatIds = $validated['seat_ids'];

        // Calculate total amount
        $totalAmount = count($seatIds) * $show->ticket_price;

        // Get or create a demo user with ID 1
        $user = User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password123')
            ]
        );

        // Create booking record
        $booking = Booking::create([
            'user_id' => $user->id,  // Use the user that exists in database
            'show_id' => $show->id,
            'number_of_seats' => count($seatIds),
            'total_amount' => $totalAmount,
            'payment_status' => 'completed',
            'booking_reference' => 'BK' . Str::random(10),
            'booking_date' => now(),
            'show_date' => $show->show_time
        ]);

        // Loop through selected seats and create tickets (LOOPS CONCEPT)
        foreach ($seatIds as $seatId) {
            TicketBooking::create([
                'booking_id' => $booking->id,
                'seat_id' => $seatId,
                'status' => 'booked'
            ]);
        }

        return response()->json([
            'success' => true,
            'booking_reference' => $booking->booking_reference,
            'total_amount' => $totalAmount,
            'booking_id' => $booking->id
        ]);
    }

    // Get user bookings (ARRAYS CONCEPT)
    public function userBookings()
    {
        // Check if user is authenticated
        if (auth()->check()) {
            // If logged in, show only user's bookings
            $bookings = auth()->user()->bookings()
                ->with('show.movie', 'show.screen.theatre', 'tickets.seat')
                ->get();
        } else {
            // Demo mode: Show ALL bookings when not authenticated
            $bookings = Booking::with('show.movie', 'show.screen.theatre', 'tickets.seat')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Map complex data to simple array (COLLECTION MAPPING)
        $bookingData = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'reference' => $booking->booking_reference,
                'movie' => $booking->show->movie->title,
                'theatre' => $booking->show->screen->theatre->name,
                'show_time' => $booking->show->show_time->format('d/m/Y H:i'),
                'seats' => $booking->tickets
                    ->pluck('seat.seat_number')
                    ->toArray(),
                'total_amount' => $booking->total_amount,
                'status' => $booking->payment_status
            ];
        });

        return view('bookings.index', ['bookings' => $bookingData]);
    }

    // Cancel booking
    public function cancel($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Check authorization only if user is logged in
        if (auth()->check() && $booking->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Cancel all tickets
        $booking->tickets()->update(['status' => 'cancelled']);
        $booking->update(['payment_status' => 'cancelled']);

        return response()->json(['success' => true, 'message' => 'Booking cancelled successfully!']);
    }
}