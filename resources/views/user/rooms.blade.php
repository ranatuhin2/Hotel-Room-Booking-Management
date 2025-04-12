@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Available Rooms</h1>
    <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-primary mb-4">Go Back to Dashboard</a>
        <div class="row" id="roomsList">
            @include('user.room.partial.table', ['rooms' => $rooms])
        </div>
        
    </div>
@endsection

@push('scripts')
<script>
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
                $('#roomsList').html(res.rooms);
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
</script>
@endpush
