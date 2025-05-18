@extends('layouts.app')
@section('title', 'Modifica Prenotazione')
@section('content')
    <h3>Modifica Prenotazione</h3>
    <form method="POST" action="{{ route('paziente.prenotazioni.update', $prenotazione->id_richiesta) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Data richiesta</label>
            <input type="date" name="data_richiesta" class="form-control" value="{{ old('data_richiesta', $prenotazione->data_richiesta) }}">
        </div>
        <div class="mb-3">
            <label>Giorno escluso</label>
            <input type="text" name="giorno_escluso" class="form-control" value="{{ old('giorno_escluso', $prenotazione->giorno_escluso) }}">
        </div>
        <button class="btn btn-primary" type="submit">Aggiorna</button>
        <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-secondary">Indietro</a>
    </form>
@endsection
