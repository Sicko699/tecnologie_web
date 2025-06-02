@extends('layouts.app')
@section('title', 'Dettaglio Agenda')

@section('content')
    <div class="container py-5">
        <!-- Header minimalista -->
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h1 class="h2 fw-light text-dark mb-2">Agenda #{{ $agenda->id }}</h1>
                <div class="text-muted">
                    {{ $agenda->dipartimento->nome ?? '-' }} • {{ $agenda->prestazione->nome ?? '-' }}
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.agende.index') }}" class="btn btn-light border-0 text-muted">
                    ← Indietro
                </a>
                <a href="{{ route('admin.agende.edit', $agenda) }}" class="btn btn-dark">
                    Modifica
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Informazioni principali -->
            <div class="col-lg-8">
                <div class="bg-light bg-opacity-50 rounded-4 p-4 mb-4">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="text-muted small mb-1">Dipartimento</div>
                            <div class="fw-medium">{{ $agenda->dipartimento->nome ?? '-' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small mb-1">Prestazione</div>
                            <div class="fw-medium">{{ $agenda->prestazione->nome ?? '-' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small mb-1">Appuntamenti massimi</div>
                            <div class="fw-medium">{{ $agenda->max_appuntamenti }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small mb-1">Creato il</div>
                            <div class="fw-medium">{{ $agenda->created_at ? $agenda->created_at->format('d/m/Y') : '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Orari -->
                <div class="bg-white border border-light rounded-4 p-4">
                    <h3 class="h5 fw-normal mb-4 text-dark">Orari disponibili</h3>

                    @php $giorni = ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato']; @endphp

                    @if(is_array($agenda->configurazione_orari) && !empty($agenda->configurazione_orari))
                        <div class="space-y-3">
                            @foreach($agenda->configurazione_orari as $giornoIdx => $orari)
                                <div class="py-3 border-bottom border-light">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="fw-medium text-dark" style="min-width: 80px;">
                                            {{ $giorni[$giornoIdx] ?? "Giorno $giornoIdx" }}
                                        </div>
                                        <div class="flex-grow-1">
                                            @if(is_array($orari) && count($orari))
                                                @foreach($orari as $orario)
                                                    <span class="badge bg-light text-dark border-0 me-2 px-3 py-2 fw-normal">
                                                        {{ $orario }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted small">Nessun orario configurato</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <div class="mb-2">—</div>
                            <div class="small">Nessun orario configurato</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="bg-white border border-light rounded-4 p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.agende.edit', $agenda) }}" class="btn btn-dark">
                                Modifica agenda
                            </a>
                            <a href="{{ route('admin.agende.index') }}" class="btn btn-light text-muted">
                                Tutte le agende
                            </a>
                        </div>

                        <hr class="my-4 border-light">

                        <div class="small text-muted">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ultima modifica</span>
                                <span>{{ $agenda->updated_at ? $agenda->updated_at->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
