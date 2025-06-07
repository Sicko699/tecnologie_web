@extends('layouts.app')
@section('title', 'Assegna Appuntamento')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center">
                    <i class="fas fa-calendar-plus me-2 text-primary"></i> Assegna Appuntamento
                </h2>

                <div class="mb-4 border rounded p-3 bg-light shadow-sm">
                    <p class="mb-1"><strong>Utente:</strong> {{ $richiesta->utente->nome }} {{ $richiesta->utente->cognome }}</p>
                    <p class="mb-0"><strong>Prestazione:</strong> {{ $richiesta->prestazione->nome }} ({{ $richiesta->prestazione->dipartimento->nome ?? '-' }})</p>
                </div>

                <!-- Form per cambiare data (separato dal form principale) -->
                <form method="GET" action="{{ route('staff.appuntamenti.create', $richiesta->id_richiesta) }}" id="dateForm">
                    <div class="mb-4">
                        <label for="data" class="form-label fw-semibold">Data</label>
                        <input type="date" id="data" name="data"
                               class="form-control @error('data') is-invalid @enderror"
                               value="{{ old('data', $dataSelezionata) }}"
                               min="{{ now()->toDateString() }}"
                               onchange="document.getElementById('dateForm').submit()" required>
                        @error('data')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Cambia la data per visualizzare gli slot disponibili.</small>
                    </div>
                </form>

                <!-- Form principale per salvare l'appuntamento -->
                <form method="POST" action="{{ route('staff.appuntamenti.store') }}">
                    @csrf
                    <input type="hidden" name="form_token" value="{{ $token }}">
                    <input type="hidden" name="id_richiesta" value="{{ $richiesta->id_richiesta }}">
                    <input type="hidden" name="data" value="{{ $dataSelezionata }}">

                    {{-- Mostra errore se il giorno è escluso --}}
                    @if($erroreGiornoEscluso)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            L'utente ha escluso il giorno <strong>{{ $erroreGiornoEscluso }}</strong>.
                            Scegli una data diversa.
                        </div>
                    @endif

                    {{-- Slot --}}
                    <div class="mb-4">
                        <label for="ora" class="form-label fw-semibold">Orario</label>
                        <select name="ora" id="ora" class="form-select @error('ora') is-invalid @enderror"
                                {{ $erroreGiornoEscluso || empty($slotDisponibili) ? 'disabled' : '' }} required>
                            <option value="">Seleziona uno slot disponibile</option>
                            @forelse($slotDisponibili as $slot)
                                <option value="{{ $slot }}" {{ old('ora') == $slot ? 'selected' : '' }}>
                                    {{ $slot }}
                                </option>
                            @empty
                                <option disabled>Nessuno slot disponibile per questa data</option>
                            @endforelse
                        </select>
                        @error('ora')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('staff.richieste.index') }}" class="btn btn-outline-secondary">Annulla</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"
                            {{ $erroreGiornoEscluso || empty($slotDisponibili) ? 'disabled' : '' }}>
                            <i class="fas fa-save me-1"></i> Salva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
