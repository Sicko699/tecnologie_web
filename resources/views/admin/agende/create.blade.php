@extends('layouts.app')
@section('title', 'Aggiungi Slot Agenda')

@section('content')
    <div class="container mt-4">
        <h1>Nuovo Slot Agenda</h1>
        <form action="{{ route('admin.agende.store') }}" method="POST">
            @csrf

            {{-- Dipartimento --}}
            <div class="form-group">
                <label for="id_dipartimento">Dipartimento</label>
                <select name="id_dipartimento" id="id_dipartimento" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento') == $d->id_dipartimento ? 'selected' : '' }}>
                            {{ $d->nome }}
                        </option>
                    @endforeach
                </select>
                @error('id_dipartimento') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Prestazione --}}
            <div class="form-group mt-2">
                <label for="id_prestazione">Prestazione</label>
                <select name="id_prestazione" id="id_prestazione" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($prestazioni as $prestazione)
                        <option value="{{ $prestazione->id_prestazione }}" {{ old('id_prestazione') == $prestazione->id_prestazione ? 'selected' : '' }}>
                            {{ $prestazione->nome }} ({{ $prestazione->dipartimento->nome }})
                        </option>
                    @endforeach
                </select>
                @error('id_prestazione') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Giorno settimana --}}
            <div class="form-group mt-2">
                <label for="giorno_settimana">Giorno della settimana</label>
                @php $giorni = ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato']; @endphp
                <select name="giorno_settimana" id="giorno_settimana" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($giorni as $k => $v)
                        <option value="{{ $k }}" {{ old('giorno_settimana') == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
                @error('giorno_settimana') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Slot orari --}}
            <div class="mb-3 mt-2">
                <label for="orari" class="form-label">Slot orari (separati da virgola)</label>
                <input type="text" class="form-control" name="orari" id="orari" placeholder="Es: 09:00-10:00,10:00-11:00" required value="{{ old('orari') }}">
                <small class="form-text text-muted">Formato: HH:MM-HH:MM — Durata fissa: 1 ora</small>
                @error('orari') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Max appuntamenti --}}
            <div class="form-group mt-2">
                <label for="max_appuntamenti">Numero massimo appuntamenti per slot</label>
                <input type="number" class="form-control" name="max_appuntamenti" id="max_appuntamenti" min="1" required value="{{ old('max_appuntamenti', 1) }}">
                @error('max_appuntamenti') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Crea</button>
            <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary mt-3">Annulla</a>
        </form>
    </div>
@endsection
