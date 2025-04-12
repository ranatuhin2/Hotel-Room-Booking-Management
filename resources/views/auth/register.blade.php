@extends('layouts.app')

@section('content')
<h1>Register</h1>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Register</button>
    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
</form>
@endsection
