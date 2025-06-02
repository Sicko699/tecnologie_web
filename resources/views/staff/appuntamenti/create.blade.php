@extends('layouts.app')
@section('title', 'Assegna Appuntamento')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    Assegna appuntamento
                </h2>

                <div class="mb-4 border rounded p-3 bg-light">
                    <div class="mb-2">
                        <span class="fw-semibold">Utente:</span>
                        {{ $richiesta->utente->nome }} {{ $richiesta->utente->cognome }}<br>
                        <span class="fw-semibold">Prestazione:</span>
                        {{ $richiesta->prestazione->nome }} ({{ $richiesta->prestazione->dipartimento->nome ?? '-' }})
                    </div>
                </div>

                <form method="POST" action="{{ route('staff.appuntamenti.store') }}">
                    @csrf
                    <input type="hidden" name="id_richiesta" value="{{ $richiesta->id_richiesta }}">

                    {{-- Data --}}
                    <div class="mb-4">
                        <label for="data" class="form-label fw-semibold">Data</label>
                        <input type="date" id="data" name="data"
                               class="form-control @error('data') is-invalid @enderror"
                               value="{{ old('data', $dataSelezionata) }}"
                               min="{{ now()->toDateString() }}"
                               onchange="this.form.submit()"
                               required>
                        @error('data')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Cambia la data per vedere gli slot disponibili.</small>
                    </div>

                    {{-- Slot orario --}}
                    <div class="mb-4">
                        <label for="ora" class="form-label fw-semibold">Orario</label>
                        <select name="ora" id="ora" class="form-select @error('ora') is-invalid @enderror" required>
                            <option value="">Seleziona uno slot disponibile</option>
                            @forelse($slotDisponibili as $slot)
                                @php
                                    $oraInizio = explode('-', $slot)[0] . ':00';
                                @endphp
                                <option value="{{ $oraInizio }}" {{ old('ora') == $oraInizio ? 'selected' : '' }}>
                                    {{ $slot }}
                                </option>
                            @empty
                                <option value="" disabled>Nessuno slot disponibile per questa data</option>
                            @endforelse
                        </select>
                        @error('ora')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-between align-items-center pt-1">
                        <a href="{{ route('staff.richieste.index') }}" class="btn btn-link text-muted px-2" style="text-decoration:none;">
                            Annulla
                        </a>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 20px;">
                            Salva appuntamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .form-label { font-size: 1.05em; margin-bottom: .3em; }
        .form-select, .form-control {
            border-radius: 12px;
            font-size: 1em;
            padding: .65em 1em;
            background: #fafbfc;
            border: 1px solid #e3e7ef;
        }
        .btn-primary { background: #2b79c9; border: none; font-weight: 500; letter-spacing: .03em; }
        .btn-primary:hover, .btn-primary:focus { background: #185f9e; }
        .btn-link { color: #888; font-weight: 400; }
        .btn-link:hover { color: #222; }
        @media (max-width: 600px) {
            .container { padding-left: 0.6em; padding-right: 0.6em; }
        }
    </style>
@endsection
