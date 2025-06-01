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
                <select name="id_dipartimento" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id }}" {{ old('id_dipartimento') == $d->id ? 'selected' : '' }}>
                            {{ $d->nome }}
                        </option>
                    @endforeach
                </select>
                @error('id_dipartimento') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Prestazione --}}
            <div class="form-group mt-2">
                <label for="id_prestazione">Prestazione</label>
                <select name="id_prestazione" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($prestazioni as $p)
                        <option value="{{ $p->id }}" {{ old('id_prestazione') == $p->id ? 'selected' : '' }}>
                            {{ $p->nome }}
                        </option>
                    @endforeach
                </select>
                @error('id_prestazione') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Giorno settimana --}}
            <div class="form-group mt-2">
                <label for="giorno_settimana">Giorno della settimana</label>
                @php $giorni = ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato']; @endphp
                <select name="giorno_settimana" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($giorni as $k => $v)
                        <option value="{{ $k }}" {{ old('giorno_settimana') == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
                @error('giorno_settimana') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Orari --}}
            <div class="mb-3 mt-2">
                <label for="orari" class="form-label">Orari di inizio (separati da virgola)</label>
                <input type="text" class="form-control" name="orari" id="orari" placeholder="Es: 09:00,10:00,11:00" required value="{{ old('orari') }}">
                @error('orari') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <a href="{{ route('admin.agende.index') }}" class="btn btn-primary">Crea</a>
            <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary">Annulla</a>
        </form>
    </div>
@endsection
