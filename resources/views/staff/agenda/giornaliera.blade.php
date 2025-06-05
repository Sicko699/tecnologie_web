@extends('layouts.app')
@section('title', 'Agenda Giornaliera')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">
            <i class="fas fa-calendar-day text-primary me-2"></i>Agenda Giornaliera
        </h2>

        {{-- FORM DI FILTRO --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('staff.agenda.giornaliera') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="id_prestazione" class="form-label">Prestazione</label>
                        <select name="id_prestazione" id="id_prestazione" class="form-select" required>
                            <option value="">-- Seleziona prestazione --</option>
                            @foreach($prestazioni as $p)
                                <option value="{{ $p->id }}" {{ request('id_prestazione') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="giorno" class="form-label">Giorno</label>
                        <input type="date" name="giorno" id="giorno" class="form-control" value="{{ request('giorno') ?? now()->toDateString() }}" required>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-search me-1"></i> Visualizza
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABELLA RISULTATI --}}
        @if(isset($appuntamenti))
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        Risultati per il giorno <strong>{{ $giorno }}</strong>
                    </h5>

                    @if(count($appuntamenti) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-primary text-center">
                                <tr>
                                    <th>Ora</th>
                                    <th>Utente</th>
                                    <th>Prestazione</th>
                                    <th>Stato</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appuntamenti as $a)
                                    <tr>
                                        <td class="text-center">{{ $a->ora }}</td>
                                        <td>{{ $a->richiesta->utente->name ?? $a->richiesta->utente->codice_fiscale }}</td>
                                        <td>{{ $a->richiesta->prestazione->nome }}</td>
                                        <td class="text-center">
                                                <span class="badge bg-{{ $a->stato === 'confermato' ? 'success' : ($a->stato === 'annullato' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($a->stato) }}
                                                </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Nessun appuntamento trovato per i criteri selezionati.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
