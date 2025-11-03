@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<h1>📋 My Bookings</h1>

@if($bookings->count() > 0)
    <table class="table table-striped" style="background: white; margin-top: 20px;">
        <thead style="background: #667eea; color: white;">
            <tr>
                <th>#</th>
                <th>Reference</th>
                <th>Movie</th>
                <th>Show Date</th>
                <th>Seats</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="color: #667eea; font-weight: bold;">{{ $booking['reference'] }}</td>
                    <td>{{ $booking['movie'] }}</td>
                    <td>{{ $booking['show_time'] }}</td>
                    <td>
                        @foreach($booking['seats'] as $seat)
                            <span style="background: #667eea; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.85rem; margin: 2px; display: inline-block;">{{ $seat }}</span>
                        @endforeach
                    </td>
                    <td><strong>₹{{ number_format($booking['total_amount'], 2) }}</strong></td>
                    <td>
                        @if($booking['status'] === 'completed')
                            <span style="background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 3px; display: inline-block;">✓ Confirmed</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 3px; display: inline-block;">✗ Cancelled</span>
                        @endif
                    </td>
                    <td>
                        @if($booking['status'] !== 'cancelled')
                            <button class="btn btn-sm btn-danger" onclick="cancelBooking({{ $booking['id'] }})">Cancel</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info" style="margin-top: 20px;">
        <h5>No bookings yet</h5>
        <a href="/movies" class="btn btn-primary">Browse Movies</a>
    </div>
@endif

@endsection

@section('scripts')
<script>
    function cancelBooking(bookingId) {
        if (confirm('Cancel this booking?')) {
            fetch(`/bookings/${bookingId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            });
        }
    }
</script>
@endsection
