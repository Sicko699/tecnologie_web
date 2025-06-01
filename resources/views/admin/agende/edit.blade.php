@extends('layouts.app')
@section('title', 'Modifica Slot Agenda')

@section('content')
    <div class="container mt-4">
        <h1>Modifica Slot Agenda</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.agende.update', ['agende' => $agenda->id_agenda]) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Dipartimento --}}
            <div class="form-group">
                <label for="id_dipartimento">Dipartimento</label>
                <select name="id_dipartimento" id="id_dipartimento" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id_dipartimento }}"
                            {{ old('id_dipartimento', $agenda->id_dipartimento) == $d->id_dipartimento ? 'selected' : '' }}>
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
                    @foreach($prestazioni as $prestazione)
                        <option value="{{ $prestazione->id_prestazione }}"
                            {{ old('id_prestazione', $agenda->id_prestazione) == $prestazione->id_prestazione ? 'selected' : '' }}>
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
                <select name="giorno_settimana" class="form-control" required>
                    @foreach($giorni as $k => $v)
                        <option value="{{ $k }}" {{ old('giorno_settimana', $agenda->giorno_settimana) == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
                @error('giorno_settimana') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Slot orari multipli --}}
            @php
                $slots = [];
                for ($h = 9; $h < 19; $h++) {
                    $start = sprintf('%02d:00', $h);
                    $end = sprintf('%02d:00', $h+1);
                    $slots[] = "$start-$end";
                }
                // Recupera orari già selezionati (array da old() oppure dall'agenda)
                $selectedOrari = old('orari', $agenda->orari ?? []);
                // Se arriva come stringa JSON decodifica
                if (is_string($selectedOrari)) {
                    $selectedOrari = json_decode($selectedOrari, true);
                }
                if (!is_array($selectedOrari)) {
                    $selectedOrari = [];
                }
            @endphp
            <div class="mb-3 mt-2">
                <label class="form-label">Slot orari disponibili</label>
                <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                    @foreach($slots as $slot)
                        <label class="btn btn-outline-primary m-1 {{ in_array($slot, $selectedOrari) ? 'active' : '' }}">
                            <input
                                type="checkbox"
                                name="orari[]"
                                value="{{ $slot }}"
                                autocomplete="off"
                                {{ in_array($slot, $selectedOrari) ? 'checked' : '' }}
                            > {{ $slot }}
                        </label>
                    @endforeach
                </div>
                <small class="form-text text-muted">Seleziona uno o più slot orari (1h ciascuno).</small>
                @error('orari') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Max appuntamenti --}}
            <div class="form-group mt-2">
                <label for="max_appuntamenti">Numero massimo appuntamenti per slot</label>
                <input type="number" class="form-control" name="max_appuntamenti" min="1" required value="{{ old('max_appuntamenti', $agenda->max_appuntamenti) }}">
                @error('max_appuntamenti') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Salva modifiche</button>
            <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary">Annulla</a>
        </form>

    </div>
@endsection
