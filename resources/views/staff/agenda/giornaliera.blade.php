@extends('layouts.app')
@section('title', 'Agenda Giornaliera')

@php
    use Carbon\Carbon;
    // Imposta la locale italiana (funziona su Linux/macOS)
    setlocale(LC_TIME, 'it_IT.UTF-8');
    // Se sei su Windows, prova anche 'italian' al posto di 'it_IT.UTF-8'
    Carbon::setLocale('it');
@endphp

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">
            <i class="fas fa-calendar-day text-primary me-2"></i>Agenda Giornaliera
        </h2>

        <form action="{{ route('staff.agenda.giornaliera') }}" method="GET" class="row g-3 align-items-end mb-4">
            <div class="col-md-5">
                <label for="id_prestazione" class="form-label">Prestazione</label>
                <select name="id_prestazione" id="id_prestazione" class="form-select" required>
                    <option value="">-- Seleziona prestazione --</option>
                    @foreach($prestazioni as $prest)
                        <option value="{{ $prest->id_prestazione }}" @if($id_prestazione == $prest->id_prestazione) selected @endif>
                            {{ $prest->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="giorno" class="form-label">Giorno</label>
                <input type="date" name="giorno" id="giorno" class="form-control" value="{{ $giorno }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary rounded-pill w-100">
                    <i class="fas fa-search me-1"></i> Cerca
                </button>
            </div>
        </form>

        @if($id_prestazione && $giorno)
            <div class="d-flex justify-content-between align-items-center mb-3">
                @php
                    $carbonGiorno = Carbon::parse($giorno);
                    $prevDay = $carbonGiorno->copy()->subDay()->toDateString();
                    $nextDay = $carbonGiorno->copy()->addDay()->toDateString();
                @endphp
                <form method="GET" action="{{ route('staff.agenda.giornaliera') }}">
                    <input type="hidden" name="id_prestazione" value="{{ $id_prestazione }}">
                    <input type="hidden" name="giorno" value="{{ $prevDay }}">
                    <button class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-chevron-left me-2"></i> Giorno precedente
                    </button>
                </form>
                <span class="fw-bold">{{ ucfirst($carbonGiorno->translatedFormat('l d F Y')) }}</span>
                <form method="GET" action="{{ route('staff.agenda.giornaliera') }}">
                    <input type="hidden" name="id_prestazione" value="{{ $id_prestazione }}">
                    <input type="hidden" name="giorno" value="{{ $nextDay }}">
                    <button class="btn btn-outline-secondary rounded-pill px-3">
                        Giorno successivo <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                </form>
            </div>
        @endif

        <div class="table-responsive" style="border-radius: 14px; overflow: hidden;">
            <table class="table table-borderless align-middle bg-white shadow-sm mb-0" style="border-radius:14px;">
                <thead class="table-light">
                <tr>
                    <th>Orario</th>
                    <th>Utente</th>
                    <th>Prestazione</th>
                    <th>Stato</th>
                    <th class="text-end">Azioni</th>
                </tr>
                </thead>
                <tbody>
                @if($appuntamenti && count($appuntamenti) > 0)
                    @foreach($appuntamenti as $a)
                        <tr>
                            <td>
                                {{ Carbon::createFromFormat('H:i:s', $a->ora)->format('H:i') }}
                            </td>
                            <td>{{ $a->richiesta->utente->name ?? $a->richiesta->utente->codice_fiscale }}</td>
                            <td>{{ $a->richiesta->prestazione->nome }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $a->stato === 'prenotato' ? 'bg-primary' : ($a->stato === 'erogato' ? 'bg-success' : 'bg-secondary') }}">
                                    {{ ucfirst($a->stato) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('staff.appuntamenti.edit', ['appuntamento' => $a->id_appuntamento]) }}"
                                   class="btn btn-outline-warning btn-sm me-1" style="border-radius:18px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('staff.appuntamenti.destroy', ['appuntamento' => $a->id_appuntamento]) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Confermi eliminazione?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" style="border-radius:18px;">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                            Nessun appuntamento trovato per questo giorno.
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <div class="mt-3 mb-2">
            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>
@endsection
