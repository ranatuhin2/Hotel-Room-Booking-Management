@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Bookings</h1>
    <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-success">Back to Dashboard</a>
    <div id="bookingList">
        @include('user.room.partial.my_book_table', ['bookings' => $bookings])
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).on('click','.cancelBooking', function(){
            const bookingId = $(this).data('id');
            const url = "{{ url('user/booking/cancel-booking') }}/" + bookingId;
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to cancel this booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('user.booking.cancel') }}",
                        type: 'DELETE',
                        data: {
                            booking_id: bookingId,
                        },
                        success: function(response) {
                            $('#bookingList').html(response.bookings);
                            Swal.fire('Cancelled!', 'Your booking has been cancelled.', 'success');

                            
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'There was an error cancelling your booking. Please try again.', 'error');
                        }
                    });
                }
            });
        });

    </script>
@endpush

