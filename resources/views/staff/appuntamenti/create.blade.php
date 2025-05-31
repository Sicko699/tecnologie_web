@extends('layouts.app')
@section('title', 'Nuovo Appuntamento')

@section('content')
    <div class="container mt-4">
        <h1>Assegna Appuntamento</h1>
        <form action="{{ route('staff.appuntamenti.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_richiesta" value="{{ $richiesta->id_richiesta }}">
            <div class="form-group">
                <label>Utente: <strong>{{ $richiesta->utente->name ?? $richiesta->utente->codice_fiscale }}</strong></label>
            </div>
            <div class="form-group">
                <label>Prestazione: <strong>{{ $richiesta->prestazione->nome }}</strong></label>
            </div>
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" name="data" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ora">Ora</label>
                <input type="time" name="ora" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Salva</button>
            <a href="{{ route('staff.richieste.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
