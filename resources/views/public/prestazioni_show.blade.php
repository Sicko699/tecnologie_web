@extends('layouts.app')
@section('title', $prestazione->nome)

@section('content')
    <div class="container mb-5">
        <h1 class="mb-3">{{ $prestazione->nome }}</h1>
        <p class="mb-4">{{ $prestazione->descrizione }}</p>

        <ul class="list-group mb-3">
            @if($prestazione->dipartimento)
                <li class="list-group-item">
                    <strong>Dipartimento:</strong> {{ $prestazione->dipartimento->nome }}
                </li>
            @endif

            @if($prestazione->medico)
                <li class="list-group-item">
                    <strong>Medico responsabile:</strong> {{ $prestazione->medico->nome }} {{ $prestazione->medico->cognome }}
                </li>
            @endif

                @if($agenda && !empty($agenda->giorni_settimana))
                    <li class="list-group-item">
                        <strong>Giorni disponibili:</strong>
                        {{ is_array($agenda->giorni_settimana) ? implode(', ', $agenda->giorni_settimana) : $agenda->giorni_settimana }}
                    </li>
                @endif


            @if($prestazione->prescrizioni)
                <li class="list-group-item">
                    <strong>Prescrizioni:</strong>
                    {{ $prestazione->prescrizioni }}
                </li>
            @endif
        </ul>


        <a href="{{ route('department.index') }}" class="btn btn-outline-secondary ms-2">
            Torna ai trattamenti
        </a>
    </div>
@endsection
