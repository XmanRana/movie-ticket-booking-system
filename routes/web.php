<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return "CinemaHub - Movie Ticket Booking System";
});

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::get('/shows/{showId}/seats', [ShowController::class, 'availableSeats']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings', [BookingController::class, 'userBookings']);
Route::delete('/bookings/{id}', [BookingController::class, 'cancel']);
