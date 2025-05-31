@extends('layouts.app')
@section('title', 'Agenda Giornaliera')

@section('content')
    <div class="container mt-4">
        <h1>Agenda Giornaliera - {{ $giorno }}</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Ora</th>
                <th>Utente</th>
                <th>Prestazione</th>
                <th>Stato</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appuntamenti as $a)
                <tr>
                    <td>{{ $a->ora }}</td>
                    <td>{{ $a->richiesta->utente->name ?? $a->richiesta->utente->codice_fiscale }}</td>
                    <td>{{ $a->richiesta->prestazione->nome }}</td>
                    <td>{{ $a->stato }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ route('staff.agenda.giornaliera.form') }}" class="btn btn-secondary mt-3">Cambia filtro</a>
    </div>
@endsection
