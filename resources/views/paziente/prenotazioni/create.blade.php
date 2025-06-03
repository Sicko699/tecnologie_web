@extends('layouts.app')
@section('title', 'Nuova Prenotazione')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    Nuova prenotazione
                </h2>
                <form method="POST" action="{{ route('paziente.prenotazioni.store') }}" class="p-0">
                    @csrf

                    {{-- Prestazione --}}
                    <div class="mb-4">
                        <label for="id_prestazione" class="form-label fw-semibold">
                            Prestazione richiesta <span class="text-danger">*</span>
                        </label>
                        <select name="id_prestazione" id="id_prestazione"
                                class="form-select @error('id_prestazione') is-invalid @enderror" required>
                            <option value="">Seleziona prestazione</option>
                            @foreach($prestazioni as $prestazione)
                                <option value="{{ $prestazione->id_prestazione }}"
                                    {{ old('id_prestazione') == $prestazione->id_prestazione ? 'selected' : '' }}>
                                    {{ $prestazione->nome }} ({{ $prestazione->dipartimento->nome ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_prestazione')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Giorno escluso --}}
                    <div class="mb-4">
                        <label for="giorno_escluso" class="form-label fw-semibold">
                            Giorno da escludere <span class="fw-normal text-muted" style="font-size:.98em;">(opzionale)</span>
                        </label>
                        <select name="giorno_escluso" id="giorno_escluso"
                                class="form-select @error('giorno_escluso') is-invalid @enderror">
                            <option value="" {{ old('giorno_escluso') == '' ? 'selected' : '' }}>Nessuno</option>
                            @php
                                $giorni = ['Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato'];
                            @endphp
                            @foreach($giorni as $giorno)
                                <option value="{{ $giorno }}"
                                    {{ old('giorno_escluso') == $giorno ? 'selected' : '' }}>
                                    {{ $giorno }}
                                </option>
                            @endforeach
                        </select>
                        @error('giorno_escluso')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Azioni --}}
                    <div class="d-flex gap-2 justify-content-between align-items-center pt-1">
                        <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-link text-muted px-2" style="text-decoration:none;">
                            Annulla
                        </a>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 20px;">
                            Invia richiesta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .form-label {
            font-size: 1.05em;
            margin-bottom: .3em;
        }
        .form-select, .form-control {
            border-radius: 12px;
            font-size: 1em;
            padding: .65em 1em;
            background: #fafbfc;
            border: 1px solid #e3e7ef;
        }
        .btn-primary {
            background: #2b79c9;
            border: none;
            font-weight: 500;
            letter-spacing: .03em;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #185f9e;
        }
        .btn-link {
            color: #888;
            font-weight: 400;
        }
        .btn-link:hover {
            color: #222;
        }
        @media (max-width: 600px) {
            .container {
                padding-left: 0.6em;
                padding-right: 0.6em;
            }
        }
    </style>
@endsection
