@extends('layouts.app')

@section('title', 'Risultati Ricerca Prestazioni')

@section('content')
    <h2>Risultati Ricerca Prestazioni</h2>

    @if($risultati->count() == 0)
        <div class="alert alert-warning">Nessuna prestazione trovata.</div>
    @else
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Nome Prestazione</th>
                <th>Dipartimento</th>
                <th>Descrizione</th>
            </tr>
            </thead>
            <tbody>
            @foreach($risultati as $prestazione)
                <tr class="clickable-row" onclick="window.location='{{ route('prestazione.show', $prestazione->id_prestazione) }}'">
                    <td>{{ $prestazione->nome }}</td>
                    <td>{{ $prestazione->dipartimento->nome ?? 'N/A' }}</td>
                    <td>{{ Str::limit($prestazione->descrizione, 80) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
@endsection
