@extends('layouts.app')
@section('title', 'Appuntamenti in agenda')

@section('content')
    <div class="container mt-4">
        <h1>Appuntamenti in Agenda</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Data</th>
                <th>Ora</th>
                <th>Utente</th>
                <th>Prestazione</th>
                <th>Stato</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appuntamenti as $a)
                <tr>
                    <td>{{ $a->data }}</td>
                    <td>{{ $a->ora }}</td>
                    <td>{{ $a->richiesta->utente->name ?? $a->richiesta->utente->codice_fiscale }}</td>
                    <td>{{ $a->richiesta->prestazione->nome }}</td>
                    <td>{{ $a->stato }}</td>
                    <td>
                        <a href="{{ route('staff.appuntamenti.edit', ['appuntamento' => $a->id_appuntamento]) }}" class="btn btn-warning btn-sm">Modifica</a>
                        <form action="{{ route('staff.appuntamenti.destroy', ['appuntamento' => $a->id_appuntamento]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confermi eliminazione?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Annulla</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
