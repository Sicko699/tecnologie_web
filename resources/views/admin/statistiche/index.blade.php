@extends('layouts.app')
@section('title', 'Statistiche')
@section('content')
    <h3>Statistiche sulle prestazioni</h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Prestazione</th>
            <th>Dipartimento</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Tipo</th>
            <th>Risultato</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statistiche as $stat)
            <tr>
                <td>{{ $stat->prestazione->nome ?? '-' }}</td>
                <td>{{ $stat->prestazione->dipartimento->nome ?? '-' }}</td>
                <td>{{ $stat->data_inizio }}</td>
                <td>{{ $stat->data_fine }}</td>
                <td>{{ $stat->tipo }}</td>
                <td>{{ $stat->risultato }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
