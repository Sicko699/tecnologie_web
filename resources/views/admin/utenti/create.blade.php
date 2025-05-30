@extends('layouts.app')
@section('title', 'Aggiungi Utente')

@section('content')
    <div class="container mt-4">
        <h1>Nuovo Utente Staff/Admin</h1>
        <form action="{{ route('admin.utenti.store') }}" method="POST">
            @csrf
            {{-- NOME --}}
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                @error('nome') <div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- COGNOME --}}
            <div class="form-group">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" name="cognome" class="form-control" id="cognome" required>
                @error('cognome') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="sesso" class="form-label">Sesso</label>
                <select name="sesso" id="sesso" class="form-control" required>
                    <option value="">Seleziona</option>
                    <option value="M">Maschio</option>
                    <option value="F">Femmina</option>
                </select>
                @error('sesso') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- TELEFONO --}}
            <div class="form-group mt-2">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" name="telefono" class="form-control">
                @error('telefono') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- CODICE FISCALE --}}
            <div class="form-group mt-2">
                <label for="codice_fiscale">Codice Fiscale</label>
                <input type="text" name="codice_fiscale" class="form-control" value="{{ old('codice_fiscale') }}" required>
                @error('codice_fiscale') <div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="form-group mt-2">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profilo</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                @error('foto') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="data_nascita" class="form-label">Data di nascita</label>
                <input type="date" name="data_nascita" class="form-control" id="data_nascita" required>
                @error('data_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
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
