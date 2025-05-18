@extends('layouts.app')
@section('title', 'I tuoi Appuntamenti')
@section('content')
    <h3>I tuoi Appuntamenti</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Data</th>
            <th>Ora</th>
            <th>Prestazione</th>
            <th>Stato</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appuntamenti as $app)
            <tr>
                <td>{{ $app->data }}</td>
                <td>{{ $app->ora }}</td>
                <td>{{ $app->richiesta->prestazione->nome ?? '-' }}</td>
                <td>{{ $app->stato }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('paziente.dashboard') }}" class="btn btn-secondary">Indietro</a>
@endsection
