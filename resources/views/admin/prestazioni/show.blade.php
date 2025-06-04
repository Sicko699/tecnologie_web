@extends('layouts.app')
@section('title', 'Dettaglio Prestazione')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h1 class="h2 fw-light text-dark mb-2">{{ $prestazione->nome }}</h1>
                <div class="text-muted">
                    Dipartimento: {{ $prestazione->dipartimento->nome ?? '-' }}
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-outline-secondary">← Indietro</a>
                <a href="{{ route('admin.prestazioni.edit', $prestazione) }}" class="btn btn-primary">Modifica</a>

            </div>
        </div>
        @if($agenda)
            <div class="mb-4">
                <h4 class="mb-2">Agenda collegata</h4>
                <div><strong>Max appuntamenti:</strong> {{ $agenda->max_appuntamenti }}</div>
                <div><strong>Slot configurati:</strong>
                    @if(is_array($agenda->configurazione_orari) && count($agenda->configurazione_orari))
                        <ul>
                            @foreach($agenda->configurazione_orari as $giornoIdx => $orari)
                                <li>
                                    <strong>{{ ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'][$giornoIdx] ?? "Giorno $giornoIdx" }}:</strong>
                                    {{ implode(', ', $orari) }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted small">Nessuno slot configurato</span>
                    @endif
                </div>
                <a href="{{ route('admin.agende.show', $agenda) }}" class="btn btn-info mt-2">Vai all’agenda</a>
            </div>
        @else
            <div class="alert alert-warning">Non esiste ancora una agenda per questa prestazione.</div>
            <a href="{{ route('admin.agende.create', [
            'id_prestazione' => $prestazione->id_prestazione,
            'id_dipartimento' => $prestazione->id_dipartimento
        ]) }}" class="btn btn-primary">
                Configura Agenda
            </a>
        @endif
    </div>
@endsection
