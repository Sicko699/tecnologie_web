@extends('layouts.app')
@section('title', 'Modifica Utente')

@section('content')
    <div class="container mt-4">
        <h1>Modifica Utente Staff/Admin</h1>
        <form action="{{ route('admin.utenti.update', ['utente' => $utente->codice_fiscale]) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $utente->name) }}" required>
                @error('name') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $utente->email) }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="ruolo">Ruolo</label>
                <select name="ruolo" class="form-control" required>
                    <option value="">Seleziona</option>
                    <option value="admin" {{ (old('ruolo', $utente->ruolo) == 'admin') ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ (old('ruolo', $utente->ruolo) == 'staff') ? 'selected' : '' }}>Staff</option>
                </select>
                @error('ruolo') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Salva</button>
            <a href="{{ route('admin.utenti.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
