@extends('layouts.app')

@section('content')
<h1>Welcome to Dashboard</h1>
<a href="{{ route('logout') }}" class="btn btn-danger btn-sm float-end">Logout</a>
<a href="{{ route('user.booking.index') }}" class="btn btn-sm btn-primary">+ Book Room</a>
<a href="{{ route('user.booking.myBookings') }}" class="btn btn-sm btn-success">My Booking</a>
@endsection
