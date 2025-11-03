@extends('layouts.app')

@section('title', 'Movies - CinemaHub')

@section('content')
<div class="mb-4">
    <h1 style="color: white;">🎬 Now Showing</h1>
    <p style="color: white; opacity: 0.8;">Discover amazing movies</p>
</div>

@if($movies->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-top: 20px;">
        @foreach($movies as $movie)
            <div class="movie-card" style="overflow: hidden; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                <!-- POSTER IMAGE - PROPERLY SIZED -->
                @if($movie->poster_url)
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" 
                         style="width: 100%; height: 380px; object-fit: cover; display: block; transition: transform 0.3s;">
                @else
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 380px; display: flex; align-items: center; justify-content: center; color: white;">
                        <span style="font-size: 4rem;">🎬</span>
                    </div>
                @endif
                
                <div style="padding: 20px; background: white;">
                    <h5 style="font-weight: bold; margin-bottom: 10px; color: #222; font-size: 1.1rem;">{{ $movie->title }}</h5>
                    
                    <div style="margin-bottom: 12px; display: flex; gap: 6px; flex-wrap: wrap;">
                        <span class="badge bg-primary" style="font-size: 0.8rem;">{{ $movie->genre }}</span>
                        <span class="badge bg-info" style="font-size: 0.8rem;">{{ $movie->language }}</span>
                    </div>
                    
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 8px;">
                        ⏱️ {{ $movie->duration }} min
                    </p>
                    
                    <div style="background: #fff3cd; padding: 6px 12px; border-radius: 20px; display: inline-block; font-weight: bold; color: #856404; margin-bottom: 15px; font-size: 0.85rem;">
                        ⭐ {{ $movie->rating }}
                    </div>
                    
                    <p style="font-size: 0.85rem; color: #555; line-height: 1.5; margin-bottom: 15px;">
                        {{ Str::limit($movie->description, 90) }}
                    </p>
                    
                    <a href="/movies/{{ $movie->id }}" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 15px; font-weight: 600;">
                        🎟️ Select Show
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info" style="margin-top: 20px;">
        <h4>No movies available</h4>
    </div>
@endif
@endsection