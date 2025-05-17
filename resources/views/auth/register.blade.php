{{-- resources/views/registrazione.blade.php --}}
@extends('layouts.app')
@section('title', 'Registrazione')
@section('content')
    <div class="container py-5">
        <h2>Registrati</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
                @error('nome') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" name="cognome" class="form-control" required>
                @error('cognome') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Conferma Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrati</button>
        </form>
    </div>
@endsection
