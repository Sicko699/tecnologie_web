@extends('layouts.app')
@section('title', $prestazione->nome)

@section('content')
    <div class="container mb-5"> {{-- Aggiunto margine inferiore --}}
        <h1>{{ $prestazione->nome }}</h1>
        <p>{{ $prestazione->descrizione }}</p>

        @if($prestazione->dipartimento)
            <p><strong>Dipartimento:</strong> {{ $prestazione->dipartimento->nome }}</p>
        @endif

        @if($prestazione->medico)
            <p><strong>Medico responsabile:</strong> {{ $prestazione->medico->nome }} {{ $prestazione->medico->cognome }}</p>
        @endif

        <a href="{{ route('department.index') }}" class="btn btn-secondary mt-3">Torna ai trattamenti</a>
    </div>
@endsection
