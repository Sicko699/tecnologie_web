@extends('layouts.app')
@section('title', 'Dettaglio Prenotazione')
@section('content')
    <h3>Dettaglio Prenotazione</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Prestazione:</strong> {{ $prenotazione->prestazione->nome }}</li>
        <li class="list-group-item"><strong>Data richiesta:</strong> {{ $prenotazione->data_richiesta }}</li>
        <li class="list-group-item"><strong>Stato:</strong> {{ $prenotazione->stato }}</li>
        <li class="list-group-item"><strong>Dipartimento:</strong> {{ $prenotazione->prestazione->dipartimento->nome }}</li>
    </ul>
    <a href="{{ route('paziente.prenotazioni.edit', $prenotazione->id_richiesta) }}" class="btn btn-warning mt-3">Modifica</a>
    <form action="{{ route('paziente.prenotazioni.destroy', $prenotazione->id_richiesta) }}" method="POST" style="display:inline">
        @csrf @method('DELETE')
        <button class="btn btn-danger mt-3" onclick="return confirm('Confermi eliminazione?')">Elimina</button>
    </form>
    <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-secondary mt-3">Indietro</a>
@endsection
