@extends('layouts.app')
@section('title', 'Aggiungi Utente Staff')

@section('content')
    <div class="container mt-4">
        <h1>Nuovo Staff</h1>
        <form action="{{ route('admin.utenti.store') }}" method="POST">
            @csrf

            {{-- NOME --}}
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                @error('nome') <div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- COGNOME --}}
            <div class="form-group mt-2">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" name="cognome" class="form-control" id="cognome" required>
                @error('cognome') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mt-2">
                <label for="id_dipartimento">Dipartimento</label>
                <select name="id_dipartimento" class="form-control" required>
                    <option value="">Seleziona dipartimento</option>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id_dipartimento }}">{{ $d->nome }}</option>
                    @endforeach
                </select>
                @error('id_dipartimento') <div class="text-danger">{{ $message }}</div>@enderror
            </div>


            {{-- USERNAME --}}
            <div class="form-group mt-2">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                @error('username') <div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- PASSWORD --}}
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
