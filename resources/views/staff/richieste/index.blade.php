@extends('layouts.app')
@section('title', 'Richieste Pendenti')

@section('content')
    <div class="container mt-4">
        <h1>Richieste Pendenti</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Utente</th>
                <th>Prestazione</th>
                <th>Giorno Escluso</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($richieste as $r)
                <tr>
                    <td>{{ $r->utente->name ?? $r->utente->codice_fiscale }}</td>
                    <td>{{ $r->prestazione->nome }}</td>
                    <td>{{ $r->giorno_escluso }}</td>
                    <td>
                        <a href="{{ route('staff.appuntamenti.create', ['richiesta' => $r->id_richiesta]) }}" class="btn btn-primary btn-sm">Assegna in agenda</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
