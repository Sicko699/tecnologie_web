@extends('layouts.app')
@section('title', 'Appuntamenti Assegnati')
@section('content')
    <h3>Appuntamenti Assegnati</h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Paziente</th>
            <th>Prestazione</th>
            <th>Data</th>
            <th>Ora</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appuntamenti as $app)
            <tr>
                <td>{{ $app->richiesta->utente->nome ?? '-' }} {{ $app->richiesta->utente->cognome ?? '' }}</td>
                <td>{{ $app->richiesta->prestazione->nome ?? '-' }}</td>
                <td>{{ $app->data }}</td>
                <td>{{ $app->ora }}</td>
                <td>{{ $app->stato }}</td>
                <td>
                    <a href="{{ route('staff.appuntamenti.edit', $app->id_appuntamento) }}" class="btn btn-warning btn-sm">Modifica</a>
                    <form action="{{ route('staff.appuntamenti.destroy', $app->id_appuntamento) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Confermi eliminazione?')">Elimina</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
