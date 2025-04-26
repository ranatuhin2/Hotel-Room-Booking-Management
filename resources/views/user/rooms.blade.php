@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Available Rooms</h1>
        <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-primary mb-4">Go Back to Dashboard</a>

        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search room number/type">
            </div>
            <div class="col-md-2">
                <select id="roomTypeFilter" class="form-control">
                    <option value="">All Types</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" id="minPrice" class="form-control" placeholder="Min Price">
            </div>
            <div class="col-md-2">
                <input type="number" id="maxPrice" class="form-control" placeholder="Max Price">
            </div>
        </div>


        <div class="row" id="roomsList">
            @include('user.room.partial.table', ['rooms' => $rooms])
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Debounce Utility
    function debounce(callback, delay) {
        let timer;
        return function () {
            clearTimeout(timer);
            timer = setTimeout(() => callback.apply(this, arguments), delay);
        };
    }

    // Bind filter input changes
    $('#searchInput, #roomTypeFilter, #minPrice, #maxPrice, #checkIn, #checkOut').on('input change', debounce(function () {
        fetchFilteredRooms();
    }, 400));

    function fetchFilteredRooms() {
        $.ajax({
            url: "{{ route('user.booking.filter') }}",
            type: 'GET',
            data: {
                search: $('#searchInput').val(),
                type: $('#roomTypeFilter').val(),
                min_price: $('#minPrice').val(),
                max_price: $('#maxPrice').val(),
            },
            success: function (res) {
                $('#roomsList').html(res.html);
            },
            error: function () {
                toastr.error('Failed to load filtered rooms.');
            }
        });
    }

    // Booking submission
    $(document).on('submit', '.bookingForm', function (e) {
        e.preventDefault();
        let form = $(this);
        let roomId = form.data('id');
        let modal = $('#bookingModal' + roomId);
        

        $.ajax({
            url: "{{ route('user.booking.book') }}",
            type: 'POST',
            data: form.serialize(),
            success: function (res) {
                toastr.success(res.message);
                modal.modal('hide');
                form[0].reset();
                $('#roomsList').html(res.rooms); // Assuming server returns partial
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, val) {
                        toastr.error(val[0]);
                    });
                } else {
                    toastr.error('Something went wrong.');
                }
            }
        });
    });



    $(document).on('click','.bookRoomBtn',function(){
        let room_id = $(this).data('id');
        /* Getting Room Id Booked Data */
        $.ajax({
            url: "{{ route('user.booking.getRoomData') }}",
            type: 'POST',
            data: {
               'room_id':room_id
            },
            success: function (res) { 


                function getDisabledDates(start, end) {
                    let dates = [];
                    let current = new Date(start);
                    while (current <= end) {
                        let formatted = current.toISOString().split('T')[0]; // YYYY-MM-DD
                        dates.push(formatted);
                        current.setDate(current.getDate() + 1);
                    }
                    return dates;
                }

                let disabledDates = [];
                
                res.forEach(entry => {
                    let checkIn = new Date(entry.check_in);
                    let checkOut = new Date(entry.check_out);
                    disabledDates = disabledDates.concat(getDisabledDates(checkIn, checkOut));
                });

                $('#bookingModal' + room_id).on('shown.bs.modal', function () {
                    flatpickr("#stayRange", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        disable: disabledDates,
                        minDate: "today",
                        showMonths: 1,
                        inline: false
                    });
                });

                
                
            },
            error: function () {
                toastr.error('Failed to load filtered rooms.');
            }
        });
    });
</script>
@endpush
