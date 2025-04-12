@if($bookings->isEmpty())
    <p>You have no bookings yet.</p>
@else
    <div class="row">
        @foreach($bookings as $booking)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Room #{{ $booking->room->room_number }}</h5>
                        <p><strong>Type:</strong> {{ $booking->room->type }}</p>
                        <p><strong>Check-In:</strong> {{ $booking->check_in }}</p>
                        <p><strong>Check-Out:</strong> {{ $booking->check_out }}</p>
                        


                        @if ($booking->room->status == 'booked')
                            <span class="badge bg-success">Booked</span>
                        @else
                            <span class="badge bg-success">Available</span>
                        @endif

                        <br>
                        <button class="btn btn-danger cancelBooking my-2" data-id="{{ $booking->id }}" >Cancel Booking</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif