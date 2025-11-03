🎬 Movie Ticket Booking System
A Laravel-based movie ticket booking system demonstrating Arrays, Structures, and Loops.

📹 Project Demo Video
Watch Full Project Demo on YouTube

(Unlisted Video - Complete Project Walkthrough)

📚 Computing Concepts
Concept	Implementation
ARRAYS	Collections: filter(), map(), groupBy(), pluck()
STRUCTURES	8 Database Tables with Foreign Keys & Eloquent ORM
LOOPS	@foreach in Blade, foreach in Controllers, Nested Loops
✨ Features
✅ Browse movies with posters

✅ View shows grouped by date

✅ Interactive seat selection (2D grid)

✅ Real-time price calculation

✅ Book tickets with confirmation

✅ View & cancel bookings

✅ Professional Bootstrap UI

✅ Responsive design

🛠️ Tech Stack
Backend: Laravel 12.36

Database: SQLite

Frontend: Blade + Bootstrap 5

Language: PHP 8.2

📦 Installation
1. Clone Repository
bash
git clone https://github.com/XmanRana/movie-ticket-booking-system.git
cd movie-ticket-booking-system
2. Install Dependencies
bash
composer install
3. Setup Environment
bash
cp .env.example .env
php artisan key:generate
4. Database
bash
php artisan migrate
5. Run Server
bash
php artisan serve
Access: http://127.0.0.1:8000/movies

🗄️ Database Tables
Users - User authentication

Movies - Movie catalog

Theatres - Cinema information

Screens - Theatre screens

Shows - Movie shows

Seats - Seat management

Bookings - Ticket bookings

TicketBookings - Individual tickets

💡 Key Code Examples
Collections (filter, map, groupBy)
php
$activeMovies = Movie::all()
    ->filter(fn($m) => $m->isActive())
    ->sortByDesc('release_date');

$groupedShows = $shows->groupBy(function($show) {
    return $show->sho
