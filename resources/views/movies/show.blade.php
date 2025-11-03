@extends('layouts.app')

@section('title', $movie->title . ' - CinemaHub')

@section('content')
<div style="background: rgba(0,0,0,0.7); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
    <h1 style="margin-bottom: 15px;">{{ $movie->title }}</h1>
    <p style="font-size: 1.1rem; margin-bottom: 15px;">{{ $movie->description }}</p>
    
    <div>
        <span class="badge bg-primary">{{ $movie->genre }}</span>
        <span class="badge bg-info">{{ $movie->language }}</span>
        <span class="badge bg-warning text-dark">{{ $movie->rating }}</span>
        <span class="badge bg-secondary">⏱️ {{ $movie->duration }} min</span>
    </div>
</div>

<h2 style="color: white; margin-bottom: 20px;">📅 Available Shows</h2>

@if($groupedShows->count() > 0)
    @foreach($groupedShows as $date => $shows)
        <div style="margin-bottom: 30px;">
            <div style="background: #ff6b6b; color: white; padding: 15px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; font-size: 1.1rem;">
                {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px;">
                @foreach($shows as $show)
                    <div class="movie-card" style="padding: 20px;">
                        <p style="color: #667eea; margin: 0; font-weight: bold;">{{ $show->screen->theatre->name }}</p>
                        <p style="color: #999; font-size: 0.9rem; margin: 5px 0;">Screen {{ $show->screen->screen_name }}</p>
                        
                        <div style="font-size: 1.5rem; font-weight: bold; color: #667eea; margin: 15px 0;">
                            {{ $show->show_time->format('h:i A') }}
                        </div>
                        
                        @if($show->getAvailableSeatsCount() > 0)
                            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; font-size: 0.85rem; margin: 10px 0; font-weight: bold; text-align: center;">
                                ✓ {{ $show->getAvailableSeatsCount() }} seats available
                            </div>
                        @else
                            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; font-size: 0.85rem; margin: 10px 0; font-weight: bold; text-align: center;">
                                ✗ SOLD OUT
                            </div>
                        @endif

                        <div style="font-size: 1.3rem; color: #ff6b6b; font-weight: bold; margin: 10px 0; text-align: center;">
                            ₹{{ number_format($show->ticket_price, 0) }}
                        </div>

                        @if($show->getAvailableSeatsCount() > 0)
                            <button class="btn btn-primary w-100" onclick="selectShow({{ $show->id }}, '{{ $show->show_time }}', {{ $show->ticket_price }})">
                                🎟️ Book Seats
                            </button>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                Sold Out
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@else
    <div class="alert alert-warning">
        <h5>No shows available for this movie</h5>
    </div>
@endif

<!-- Seat Selection Modal -->
<div class="modal fade" id="seatModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #667eea; color: white;">
                <h5 class="modal-title">🎟️ Select Your Seats</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="seatContainer" style="max-height: 400px; overflow-y: auto; padding: 20px;">
                    Loading seats...
                </div>
                <div style="margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
                    <strong style="font-size: 1.2rem;">Total: ₹<span id="totalAmount">0</span></strong><br>
                    <small>Selected: <span id="selectedSeatsDisplay">None</span></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="proceedBooking()">Proceed to Payment</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let currentShowId = null;
    let currentTicketPrice = null;

    function selectShow(showId, showTime, price) {
        currentShowId = showId;
        currentTicketPrice = price;
        
        console.log('Loading seats for show:', showId);
        
        fetch(`/shows/${showId}/seats`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Failed to load seats');
                }
                return response.json();
            })
            .then(data => {
                console.log('Seats data:', data);
                let html = `<h6 style="margin-bottom: 20px;">${data.movie} • ${showTime} • ₹${price}/seat</h6>`;
                html += '<div style="display: grid; grid-template-columns: repeat(10, 1fr); gap: 8px; margin-bottom: 20px;">';
                
                data.seats.forEach(seat => {
                    html += `
                        <label style="cursor: pointer; display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <input type="checkbox" name="seats" value="${seat.id}" data-price="${seat.price}" 
                                   style="transform: scale(1.5); margin-bottom: 5px;" onchange="updateTotal()">
                            <small style="font-size: 0.75rem; color: #666;">${seat.number}</small>
                        </label>
                    `;
                });
                
                html += '</div>';
                document.getElementById('seatContainer').innerHTML = html;
                
                const modal = new bootstrap.Modal(document.getElementById('seatModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error loading seats:', error);
                alert('Error loading seats: ' + error.message);
            });
    }

    function updateTotal() {
        const checkboxes = document.querySelectorAll('input[name="seats"]:checked');
        let total = 0;
        let seats = [];

        checkboxes.forEach(cb => {
            const seatLabel = cb.parentElement.querySelector('small').textContent;
            seats.push(seatLabel);
            total += parseFloat(cb.dataset.price);
        });

        document.getElementById('totalAmount').textContent = total.toFixed(2);
        document.getElementById('selectedSeatsDisplay').textContent = seats.length > 0 ? seats.join(', ') : 'None';
    }

    function proceedBooking() {
        const checkboxes = document.querySelectorAll('input[name="seats"]:checked');
        
        if (checkboxes.length === 0) {
            alert('Please select at least one seat!');
            return;
        }

        const seatIds = Array.from(checkboxes).map(cb => cb.value);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        console.log('Sending booking request with:', { show_id: currentShowId, seat_ids: seatIds, csrf: csrfToken });

        fetch('/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                show_id: currentShowId,
                seat_ids: seatIds
            })
        })
        .then(response => {
            console.log('Booking response status:', response.status);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error response text:', text);
                    throw new Error('Server error: ' + response.status);
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Booking success:', data);
            if (data.success) {
                alert(`✅ Booking Successful!\n\nReference: ${data.booking_reference}\nTotal: ₹${data.total_amount}\n\nYou will be redirected to your bookings...`);
                window.location.href = '/bookings';
            } else {
                alert('Booking failed: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Full error:', error);
            alert('Error: ' + error.message);
        });
    }
</script>
@endsection