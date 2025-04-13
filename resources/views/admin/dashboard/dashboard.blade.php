@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Admin Dashboard</h1>
    <a href="{{ route('logout') }}" class="btn btn-danger btn-sm float-end">Logout</a>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-sm btn-primary">Room Management</a>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Total Rooms</h5>
                    <h3>{{ $totalRooms }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Total Bookings</h5>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5>Upcoming Bookings</h5>
                    <h3>{{ $upcomingBookings }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5>Past Bookings</h5>
                    <h3>{{ $pastBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Booking Trends Chart --}}
        <div class="col-md-6">
            <canvas id="bookingTrendsChart"></canvas>
        </div>

        {{-- Most Booked Room Type Chart --}}
        <div class="col-md-6">
            <canvas id="roomTypeChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bookingTrends = @json($bookingTrends);
    const roomTypeData = @json($roomTypeChart);

    // Booking Trends Chart
    const ctx1 = document.getElementById('bookingTrendsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: bookingTrends.labels,
            datasets: [{
                label: 'Bookings Per Month',
                data: bookingTrends.data,
                borderColor: 'blue',
                backgroundColor: 'rgba(0,0,255,0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // Most Booked Room Type Chart
    const ctx2 = document.getElementById('roomTypeChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: roomTypeData.labels,
            datasets: [{
                label: 'Most Booked Room Types',
                data: roomTypeData.data,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
            }]
        }
    });
</script>
@endpush
