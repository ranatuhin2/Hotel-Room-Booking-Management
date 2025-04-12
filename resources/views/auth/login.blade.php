@extends('layouts.app')

@section('content')
<div class="container w-50">
    <h1 class="text-center" style="text-decoration:blue underline" >Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </form>
</div>
@endsection
