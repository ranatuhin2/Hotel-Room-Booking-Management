<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Requests\Room\CreateRequest;
use App\Http\Requests\Room\UpdateRoomRequest;


class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(5);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function loadRooms()
    {
        $rooms = Room::latest()->paginate(5);

        $html = view('admin.rooms.partial.table', compact('rooms'))->render();

        return response()->json(['html' => $html]);
    }


    public function store(CreateRequest $request)
    {
        Room::create($request->validated());

        $rooms = Room::latest()->paginate(1);

        $html = view('admin.rooms.partial.table', compact('rooms'))->render();

        return response()->json([
            'message' => 'Room created successfully.',
            'html' => $html,
        ]);
    }
    

    public function edit(Room $room)
    {
        return response()->json($room);
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        return response()->json(['message' => 'Room updated successfully']);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }
}
