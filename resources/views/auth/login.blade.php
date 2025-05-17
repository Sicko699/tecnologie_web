{{-- resources/views/login.blade.php --}}
@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="container py-5">
        <h2>Accedi</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Accedi</button>
        </form>
    </div>
@endsection
