
@forelse ($rooms as $room)
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Room #{{ $room->room_number }}</h5>
                <p class="card-text"><strong>Type:</strong> {{ $room->type }}</p>
                <p class="card-text"><strong>Price:</strong> ₹{{ $room->price }}</p>
                <p class="card-text"><strong>Status: </strong>{{ $room->status }}</p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-success bookRoomBtn"
                            data-id="{{ $room->id }}"
                            data-bs-toggle="modal"
                            data-bs-target="#bookingModal{{ $room->id }}">
                        <i class="fas fa-calendar-plus me-1"></i> Book
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="bookingForm" data-id="{{ $room->id }}">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Book Room #{{ $room->room_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="mb-3">
                            <label for="check_in" class="form-label">Check-In Date</label>
                            <input type="date" class="form-control" name="check_in" required>
                        </div>
                        <div class="mb-3">
                            <label for="check_out" class="form-label">Check-Out Date</label>
                            <input type="date" class="form-control" name="check_out" required>
                        </div> --}}
                        <label>Select Stay Duration</label>
                        <input type="text" id="stayRange" name="date_range" class="form-control" placeholder="Select your stay dates" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Book Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info">No rooms available at the moment.</div>
    </div>
@endforelse
