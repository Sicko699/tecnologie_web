@extends('layouts.app')
@section('title', 'Nuova Richiesta')
@section('content')
    <h3>Nuova Richiesta</h3>
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
            @php
                $giorni = ['Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'];
                $oldGiorno = old('giorno_escluso');
            @endphp
            <select name="giorno_escluso" class="form-control">
                <option value="">-- Nessuno --</option>
                @foreach($giorni as $key => $giorno)
                    <option value="{{ $key }}" @if($oldGiorno !== null && $oldGiorno == $key) selected @endif>{{ $giorno }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success" type="submit">Salva</button>
        <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-secondary">Indietro</a>
    </form>
@endsection
