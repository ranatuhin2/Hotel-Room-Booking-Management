<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Requests\Room\CreateRequest;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(1);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(CreateRequest $request)
    {
        Room::create($request->validated());
        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }
}
