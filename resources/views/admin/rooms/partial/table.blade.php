@foreach($rooms as $key => $room)
    <tr>
        <td>{{ ++$key }}</td>
        <td>{{ $room->room_number }}</td>
        <td>{{ $room->type }}</td>
        <td>{{ $room->price }}</td>
        <td>{{ $room->status }}</td>
        <td>
            <a href="javascript:void(0)" id="editRoomBtn" data-id="{{ $room->id }}" class="btn btn-lg" ><i class="fas fa-edit"></i></a>
            <a href="javascript:void(0)" id="removeRoomBtn" data-id="{{ $room->id }}" class="btn btn-lg" ><i class="fas fa-trash text-danger"></i></a>
        </td>
    </tr>
@endforeach
