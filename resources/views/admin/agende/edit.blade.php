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

            {{-- Slot orario --}}
            <div class="form-group">
                <label for="slot_orario">Slot Orario</label>
                <input type="text" name="slot_orario" id="slot_orario" class="form-control"
                       value="{{ old('slot_orario', $agenda->slot_orario) }}" required>
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
