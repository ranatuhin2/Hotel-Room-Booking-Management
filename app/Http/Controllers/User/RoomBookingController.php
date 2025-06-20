<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoomBook\CreateRequest;
use App\Http\Requests\RoomBook\UpdateRequest;

class RoomBookingController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('user.rooms', compact('rooms'));
    }

    public function book(CreateRequest $request)
    {
        $dateRange = $request->date_range;
        list($checkIn, $checkOut) = explode(" to ", $dateRange);
        $room = Room::findOrFail($request->room_id);
        
        $room->status = 'booked';
        $room->save();

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' =>$checkIn,
            'check_out' => $checkOut,
        ]);

        $rooms = Room::all();

        return response()->json([
            'message' => 'Room booked successfully!',
            'rooms' => view('user.room.partial.table', compact('rooms'))->render(),
        ]);
    }

    public function myBookings()
    {
        $bookings = Auth::user()
        ->bookings() 
        ->with('room')
        ->latest()
        ->get();
        return view('user.my_booking', compact('bookings'));
    }

    public function cancel(Request $request)
    {
        $bookingId = $request->booking_id;
        $booking = Booking::findOrFail($bookingId);
        if ($booking->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $booking->room->update(['status' => 'available']);
        $booking->delete();

        $bookings = Auth::user()
        ->bookings() 
        ->with('room')
        ->latest()
        ->get();

        return response()->json([
            'message' => 'Booking cancelled successfully.',
            'bookings' => view('user.room.partial.my_book_table', compact('bookings'))->render(),
        ]);
    }



    public function filter(Request $request)
    {
        $query = Room::where('status', 'available');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('room_number', 'like', '%' . $request->search . '%')
                ->orWhere('type', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }



        $rooms = $query->get();

        $html = view('user.room.partial.table', compact('rooms'))->render();

        return response()->json(['html' => $html]);
    }


    public function getRoomData(Request $request)
    {
        $room = Room::findOrFail($request->room_id);
        $booking = $room->bookings;
        return response()->json($booking);

    }
}
