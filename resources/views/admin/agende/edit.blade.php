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
                <select name="id_dipartimento" class="form-control" required>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id }}" {{ old('id_dipartimento', $agenda->id_dipartimento) == $d->id ? 'selected' : '' }}>
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
                    @foreach($prestazioni as $p)
                        <option value="{{ $p->id }}" {{ old('id_prestazione', $agenda->id_prestazione) == $p->id ? 'selected' : '' }}>
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
                    @foreach($giorni as $k => $v)
                        <option value="{{ $k }}" {{ old('giorno_settimana', $agenda->giorno_settimana) == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
                @error('giorno_settimana') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Orario inizio --}}
            <div class="form-group mt-2">
                <label for="orario_inizio">Orario Inizio</label>
                <input type="time" name="orario_inizio" class="form-control" required value="{{ old('orario_inizio', $agenda->orario_inizio) }}">
                @error('orario_inizio') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salva Modifiche</button>
                <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary">Annulla</a>
            </div>
        </form>
    </div>
@endsection
