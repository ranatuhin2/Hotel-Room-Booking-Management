@extends('layouts.app')

@section('content')
<h2>Welcome to Dashboard</h2>
<a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
@endsection
