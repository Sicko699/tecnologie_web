@extends('layouts.app')
@section('title', 'Nuova Prenotazione')
@section('content')
    <h3>Nuova Prenotazione</h3>
    <form method="POST" action="{{ route('paziente.prenotazioni.store') }}">
        @csrf
        <div class="mb-3">
            <label>Prestazione</label>
            <select name="id_prestazione" class="form-control">
                @foreach($prestazioni as $prestazione)
                    <option value="{{ $prestazione->id_prestazione }}">{{ $prestazione->nome }} ({{ $prestazione->dipartimento->nome }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Data richiesta</label>
            <input type="date" name="data_richiesta" class="form-control" value="{{ old('data_richiesta') }}">
        </div>
        <div class="mb-3">
            <label>Giorno escluso (opzionale)</label>
            <input type="text" name="giorno_escluso" class="form-control" value="{{ old('giorno_escluso') }}">
        </div>
        <button class="btn btn-success" type="submit">Salva</button>
        <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-secondary">Indietro</a>
    </form>
@endsection
