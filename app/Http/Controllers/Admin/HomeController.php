<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class HomeController extends Controller
{
    public function dashboard()
    {
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $upcomingBookings = Booking::where('check_in', '>', now())->count();
        $pastBookings = Booking::where('check_out', '<', now())->count();

        // Booking Trends (past 6 months)
        $bookingTrends = Booking::selectRaw('MONTHNAME(check_in) as month, COUNT(*) as count')
            ->where('check_in', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderByRaw('MIN(check_in)')
            ->get();

        $trendsLabels = $bookingTrends->pluck('month');
        $trendsData = $bookingTrends->pluck('count');

        // Most Booked Room Types
        $roomTypeCounts = Booking::join('rooms', 'rooms.id', '=', 'bookings.room_id')
            ->selectRaw('rooms.type, COUNT(*) as total')
            ->groupBy('rooms.type')
            ->get();

        $roomTypeLabels = $roomTypeCounts->pluck('type');
        $roomTypeData = $roomTypeCounts->pluck('total');

        return view('admin.dashboard.dashboard', [
            'totalRooms' => $totalRooms,
            'totalBookings' => $totalBookings,
            'upcomingBookings' => $upcomingBookings,
            'pastBookings' => $pastBookings,
            'bookingTrends' => [
                'labels' => $trendsLabels,
                'data' => $trendsData
            ],
            'roomTypeChart' => [
                'labels' => $roomTypeLabels,
                'data' => $roomTypeData
            ]
        ]);
    }
}
