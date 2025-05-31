@extends('layouts.app')
@section('title', 'Aggiungi Utente')

@section('content')
    <div class="container mt-4">
        <h1>Nuovo Utente Staff/Admin</h1>
        <form action="{{ route('admin.utenti.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="ruolo">Ruolo</label>
                <select name="ruolo" class="form-control" required>
                    <option value="">Seleziona</option>
                    <option value="admin" {{ old('ruolo') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ old('ruolo') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('ruolo') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="password_confirmation">Conferma Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Crea</button>
            <a href="{{ route('admin.utenti.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
