<?php
@extends('layouts.app')
@section('title', 'Risultati Ricerca Prestazioni')
@section('content')
<h2>Risultati Ricerca Prestazioni</h2>
<form class="d-flex mb-3" method="GET" action="{{ route('ricerca.prestazioni') }}">
    <input class="form-control me-2" type="search" placeholder="Cerca prestazioni o dipartimento" aria-label="Cerca" name="q" value="{{ request('q') }}">
    <button class="btn btn-outline-primary" type="submit">Cerca</button>
</form>
@if($risultati->count() == 0)
    <div class="alert alert-warning">Nessuna prestazione trovata.</div>
@else
<table class="table">
    <thead>
        <tr>
            <th>Nome Prestazione</th>
            <th>Dipartimento</th>
            <th>Descrizione</th>
        </tr>
    </thead>
    <tbody>
@foreach($risultati as $prestazione)
            <tr>
                <td>{{ $prestazione->nome }}</td>
                <td>{{ $prestazione->dipartimento->nome }}</td>
                <td>{{ $prestazione->descrizione }}</td>
            </tr>
@endforeach
    </tbody>
</table>
@endif
@endsection

