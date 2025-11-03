<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Display all movies
    public function index()
    {
        $movies = Movie::all();
        
        // Filter active movies using collection (ARRAYS CONCEPT)
        $activeMovies = collect($movies)
            ->filter(fn($movie) => $movie->isActive())
            ->sortByDesc('release_date');

        return view('movies.index', ['movies' => $activeMovies]);
    }

    // Show movie details
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        $shows = $movie->shows()
            ->with('screen.theatre')
            ->where('show_time', '>', now())
            ->orderBy('show_time')
            ->get();

        // Group shows by date (ARRAYS CONCEPT)
        $groupedShows = $shows->groupBy(function ($show) {
            return $show->show_time->format('Y-m-d');
        });

        return view('movies.show', [
            'movie' => $movie,
            'groupedShows' => $groupedShows
        ]);
    }

    // Create new movie
    public function create()
    {
        return view('movies.create');
    }

    // Store movie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'genre' => 'required|string',
            'language' => 'required|string',
            'duration' => 'required|integer',
            'rating' => 'required|string',
            'release_date' => 'required|date'
        ]);

        Movie::create($validated);

        return redirect()->route('movies.index')->with('success', 'Movie created!');
    }
}
