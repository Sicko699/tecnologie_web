@extends('layouts.app')
@section('title', 'Dettaglio Prenotazione')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    Dettaglio prenotazione
                </h2>
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 14px;">
                    <div class="card-body px-4 py-4">
                        <dl class="row mb-0">
                            <dt class="col-5 fw-normal text-muted small">Prestazione</dt>
                            <dd class="col-7 mb-3">
                                {{ $prenotazione->prestazione->nome ?? '-' }}
                                <span class="text-muted small d-block">
                                    {{ $prenotazione->prestazione->dipartimento->nome ?? '' }}
                                </span>
                            </dd>

                            <dt class="col-5 fw-normal text-muted small">Giorno escluso</dt>
                            <dd class="col-7 mb-3">
                                {{ $prenotazione->giorno_escluso ?? '—' }}
                            </dd>

                            <dt class="col-5 fw-normal text-muted small">Stato</dt>
                            <dd class="col-7 mb-3">
                                <span class="badge rounded-pill bg-{{ $prenotazione->stato === 'in attesa' ? 'warning text-dark' : 'success' }}">
                                    {{ ucfirst($prenotazione->stato) }}
                                </span>
                            </dd>

                            <dt class="col-5 fw-normal text-muted small">ID richiesta</dt>
                            <dd class="col-7 mb-0">
                                {{ $prenotazione->id_richiesta }}
                            </dd>
                        </dl>
                    </div>
                </div>
                {{-- Azioni --}}
                <div class="d-flex justify-content-between align-items-center gap-2 pt-2">
                    <a href="{{ route('paziente.prenotazioni.edit', $prenotazione->id_richiesta) }}" class="btn btn-primary px-4" style="border-radius: 20px;">
                        Modifica
                    </a>
                    <form action="{{ route('paziente.prenotazioni.destroy', $prenotazione->id_richiesta) }}" method="POST" onsubmit="return confirm('Eliminare la prenotazione?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger px-4" style="border-radius: 20px;">
                            Elimina
                        </button>
                    </form>
                    <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-link text-muted px-2" style="text-decoration:none;">
                        Torna alla lista
                    </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card { border-radius: 14px; }
        .btn-primary {
            background: #2b79c9;
            border: none;
            font-weight: 500;
            letter-spacing: .03em;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #185f9e;
        }
        .btn-outline-danger {
            border-radius: 20px;
        }
        .btn-link {
            color: #888;
            font-weight: 400;
        }
        .btn-link:hover {
            color: #222;
        }
        dt { font-weight: 400 !important; }
        @media (max-width: 600px) {
            .container {
                padding-left: 0.6em;
                padding-right: 0.6em;
            }
        }
    </style>
@endsection
