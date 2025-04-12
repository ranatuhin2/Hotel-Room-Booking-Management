@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Room List</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-success">Back to Dashboard</a>
        <a href="javascript:void(0)" id="addRoomBtn" class="btn btn-sm btn-primary">+ Add Room</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Room Number</th>
                <th>Type</th>
                <th>Price</th>
                <th>Status</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody id="rooms-list" >
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ $room->type }}</td>
                    <td>{{ number_format($room->price, 2) }}</td>
                    <td>{{ ucfirst($room->status) }}</td>
                    <td>
                        <a href="javascript:void(0)" id="editRoomBtn" data-id="{{ $room->id }}" class="btn btn-lg" ><i class="fas fa-edit"></i></a>
                        
                        <a href="javascript:void(0)" id="removeRoomBtn" class="btn btn-lg" ><i class="fas fa-trash text-danger"></i></a>
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No rooms found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $rooms->links() }}
    </div>


    <!-- Room Create Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addRoomForm">
                @csrf
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Room Number</label>
                        <input type="text" name="room_number" class="form-control" placeholder="Room Number">
                        <div class="text-danger error-room_number"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="">Select Room Type</option>
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                        </select>
                        <div class="text-danger error-type"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price</label>
                        <input type="number" name="price" step="0.01" class="form-control" placeholder="Room Price">
                        <div class="text-danger error-price"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Select Status </option>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                        </select>
                        <div class="text-danger error-status"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form id="editRoomForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_room_id">
                <div class="mb-3">
                <label>Room Number</label>
                <input type="text" class="form-control" name="room_number" id="edit_room_number">
                <small class="text-danger error-room_number"></small>
                </div>
                <div class="mb-3">
                <label>Type</label>
                <select class="form-control" name="type" id="edit_room_type">
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                </select>
                <small class="text-danger error-type"></small>
                </div>
                <div class="mb-3">
                <label>Price</label>
                <input type="number" class="form-control" name="price" id="edit_room_price">
                <small class="text-danger error-price"></small>
                </div>
                <div class="mb-3">
                <label>Status</label>
                <select class="form-control" name="status" id="edit_room_status">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                </select>
                <small class="text-danger error-status"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Room</button>
            </div>
            </div>
        </form>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {


        
    });

    $(document).on('click','#addRoomBtn', function(){
        $('.text-danger').text('');
        $('#addRoomModal').modal('show');
    });


    $(document).on('click','#editRoomBtn', function(){
        const id = $(this).data('id');
        const url = "{{ url('admin/rooms/edit')}}/" +  id;
        
        $.ajax({
            url: url,
            method: "GET",
            success: function (data) {
                $('#edit_room_id').val(data.id);
                $('#edit_room_number').val(data.room_number);
                $('#edit_room_type option').each(function () {
                    if ($(this).val() === data.type.trim()) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });
                $('#edit_room_price').val(data.price);
                $('#edit_room_status option').each(function () {
                    if ($(this).val() === data.status.trim()) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });
                $('#editRoomModal').modal('show');
            }
        });
    });


    $('#addRoomForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('admin.rooms.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                $('#addRoomModal').modal('hide');
                Swal.fire({
                    title: "Success!",
                    text: "Room added successfully!",
                    icon: "success",
                    draggable: true
                });
                loadRooms();
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });
    });

    $('#editRoomForm').submit(function (e) {
        e.preventDefault();
        const id = $('#edit_room_id').val();
        $('.text-danger').text('');

        $.ajax({
            url: "{{ url('admin/rooms/update') }}/" + id,
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                $('#editRoomModal').modal('hide');
                loadRooms();
                Swal.fire({
                    title: "Success!",
                    text: "Room updated successfully!",
                    icon: "success",
                    draggable: true
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                }
            }
        });
    });


    $(document).on('click', '#removeRoomBtn', function () {
        const id = $(this).closest('tr').find('#editRoomBtn').data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Room will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/rooms/delete') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        loadRooms();
                        Swal.fire('Deleted!', 'Room has been removed.', 'success');
                    }
                });
            }
        });
    });

    

    function loadRooms()
    {
        $.ajax({
            url: "{{ route('admin.rooms.load') }}",
            method: "GET",
            success: function (response) {
                $('#rooms-list').html(response.html);
            }
        });
    }

</script>
@endpush
