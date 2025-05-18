@extends('layouts.app')
@section('title', 'Profilo Utente')
@section('content')
    <h3>Profilo di {{ Auth::user()->nome }} {{ Auth::user()->cognome }}</h3>
    <form method="POST" action="{{ route('paziente.profilo.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" class="form-control" name="nome" value="{{ old('nome', Auth::user()->nome) }}">
        </div>
        <div class="mb-3">
            <label>Cognome</label>
            <input type="text" class="form-control" name="cognome" value="{{ old('cognome', Auth::user()->cognome) }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}">
        </div>
        <div class="mb-3">
            <label>Telefono</label>
            <input type="text" class="form-control" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}">
        </div>
        <button class="btn btn-primary" type="submit">Salva modifiche</button>
        <a href="{{ route('paziente.dashboard') }}" class="btn btn-secondary">Indietro</a>
    </form>
    <form method="POST" action="{{ route('paziente.account.delete') }}" class="mt-3">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare il tuo account?');">Elimina Account</button>
    </form>
@endsection
