# 🎬 Movie Ticket Booking System

A Laravel-based movie ticket booking system demonstrating **Arrays**, **Structures**, and **Loops**.

---

## 📹 Project Demo Video

[![Movie Ticket Booking System - Demo](https://img.youtube.com/vi/kG8FWBFK9Y4/maxresdefault.jpg)](https://youtu.be/kG8FWBFK9Y4)

**[▶️ Watch Full Project Demo on YouTube](https://youtu.be/kG8FWBFK9Y4)**

---

## 📚 Computing Concepts

| Concept | Implementation |
|---------|-----------------|
| **ARRAYS** | Collections: `filter()`, `map()`, `groupBy()`, `pluck()` |
| **STRUCTURES** | 8 Database Tables with Foreign Keys & Eloquent ORM |
| **LOOPS** | `@foreach` in Blade, `foreach` in Controllers, Nested Loops |

---

## ✨ Features

- ✅ Browse movies with posters
- ✅ View shows grouped by date
- ✅ Interactive seat selection (2D grid)
- ✅ Real-time price calculation
- ✅ Book tickets with confirmation
- ✅ View & cancel bookings
- ✅ Professional Bootstrap UI
- ✅ Responsive design

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12.36
- **Database:** SQLite
- **Frontend:** Blade + Bootstrap 5
- **Language:** PHP 8.2

---

## 📦 Installation

### 1. Clone Repository
```bash
git clone https://github.com/XmanRana/movie-ticket-booking-system.git
cd movie-ticket-booking-system
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database
```bash
php artisan migrate
```

### 5. Run Server
```bash
php artisan serve
```

**Access:** `http://127.0.0.1:8000/movies`

---

## 🗄️ Database Tables

1. **Users** - User authentication
2. **Movies** - Movie catalog
3. **Theatres** - Cinema information
4. **Screens** - Theatre screens
5. **Shows** - Movie shows
6. **Seats** - Seat management
7. **Bookings** - Ticket bookings
8. **TicketBookings** - Individual tickets

---

## 💡 Key Code Examples

### Collections (filter, map, groupBy)
```php
$activeMovies = Movie::all()
    ->filter(fn($m) => $m->isActive())
    ->sortByDesc('release_date');

$groupedShows = $shows->groupBy(function($show) {
    return $show->show_time->format('Y-m-d');
});
```

### Loops (Creating Tickets)
```php
foreach ($seatIds as $seatId) {
    TicketBooking::create([
        'booking_id' => $booking->id,
        'seat_id' => $seatId
    ]);
}
```

### Blade @foreach
```blade
@foreach($movies as $movie)
    @foreach($movie->shows as $show)
        {{ $show->show_time }}
    @endforeach
@endforeach
```

---

## 🎯 Project Structure

```
app/
├── Models/ (7 models)
└── Http/Controllers/ (3 controllers)

database/
└── migrations/ (7 migration files)

resources/views/
├── layouts/app.blade.php
├── movies/
│   ├── index.blade.php
│   └── show.blade.php
└── bookings/index.blade.php

routes/web.php
```

---

## 📝 Features Walkthrough

### Browse Movies
- View all movies with posters at `/movies`
- See genre, language, duration, rating

### Select Show
- Click on movie to view details
- Choose show by date & time
- View available seats count

### Book Tickets
- Click "Book Seats"
- Select multiple seats from grid
- See real-time total price
- Click "Proceed to Payment"

### Manage Bookings
- Click "My Bookings" at `/bookings`
- View all your bookings
- See booking reference number
- Cancel bookings anytime

---

## 🔧 Commands

```bash
php artisan cache:clear
php artisan tinker
php artisan migrate
php artisan route:list
php artisan serve
```

---

## ✅ Computing Concepts Checklist

- ✅ **Arrays:** filter(), map(), groupBy(), pluck() operations
- ✅ **Structures:** 8-table relational database with proper relationships
- ✅ **Loops:** Multiple @foreach in views, foreach in controllers, nested loops

---

## 👨‍💻 Authors

**XmanRana**

**Xagarrr**
---

**Status:** ✅ Complete | **Updated:** Nov 3, 2025
