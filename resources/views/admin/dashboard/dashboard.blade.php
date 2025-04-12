@extends('layouts.app')

@section('content')
<h1>Welcome to Dashboard</h1>
<a href="{{ route('logout') }}" class="btn btn-danger btn-sm float-end">Logout</a>
<a href="{{ route('admin.rooms.index') }}" class="btn btn-sm btn-primary">Room Management</a>
@endsection
