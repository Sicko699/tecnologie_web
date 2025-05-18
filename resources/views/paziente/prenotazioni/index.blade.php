@extends('layouts.app')
@section('title', 'Le tue Prenotazioni')
@section('content')
    <h3>Gestisci Prenotazioni</h3>
    <a href="{{ route('paziente.prenotazioni.create') }}" class="btn btn-success mb-3">Nuova Prenotazione</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Prestazione</th>
            <th>Data Richiesta</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        @foreach($prenotazioni as $prenotazione)
            <tr>
                <td>{{ $prenotazione->prestazione->nome }}</td>
                <td>{{ $prenotazione->data_richiesta }}</td>
                <td>{{ $prenotazione->stato }}</td>
                <td>
                    <a href="{{ route('paziente.prenotazioni.show', $prenotazione->id_richiesta) }}" class="btn btn-info btn-sm">Visualizza</a>
                    <a href="{{ route('paziente.prenotazioni.edit', $prenotazione->id_richiesta) }}" class="btn btn-warning btn-sm">Modifica</a>
                    <form action="{{ route('paziente.prenotazioni.destroy', $prenotazione->id_richiesta) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Confermi eliminazione?')">Elimina</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('paziente.dashboard') }}" class="btn btn-secondary">Indietro</a>
@endsection
