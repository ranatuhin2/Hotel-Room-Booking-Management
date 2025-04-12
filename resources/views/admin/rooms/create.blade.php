@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Add New Room</h3>

    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="room_number">Room Number</label>
            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number') }}">
            @error('room_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="type">Type</label>
            <select name="type" class="form-control @error('type') is-invalid @enderror">
                <option value="">-- Select Type --</option>
                <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="double" {{ old('type') == 'double' ? 'selected' : '' }}>Double</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="status">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="">Select Status</option>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">Create Room</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Go Back</a>
    </form>
</div>
@endsection
