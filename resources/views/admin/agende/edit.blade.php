@extends('layouts.app')
@section('title', 'Modifica Slot Agenda')

@section('content')
    <div class="container mt-4">
        <h1>Modifica Slot Agenda</h1>
        <form action="{{ route('admin.agende.update', ['agende' => $agenda->id]) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="dipartimento_id">Dipartimento</label>
                <select name="dipartimento_id" class="form-control" required>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id }}" {{ (old('dipartimento_id', $agenda->dipartimento_id) == $d->id) ? 'selected' : '' }}>{{ $d->nome }}</option>
                    @endforeach
                </select>
                @error('dipartimento_id') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="prestazione_id">Prestazione</label>
                <select name="prestazione_id" class="form-control" required>
                    @foreach($prestazioni as $p)
                        <option value="{{ $p->id }}" {{ (old('prestazione_id', $agenda->prestazione_id) == $p->id) ? 'selected' : '' }}>{{ $p->nome }}</option>
                    @endforeach
                </select>
                @error('prestazione_id') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="giorno_settimana">Giorno della settimana</label>
                <select name="giorno_settimana" class="form-control" required>
                    @php $giorni = ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica']; @endphp
                    @foreach($giorni as $k => $v)
                        <option value="{{ $k }}" {{ (old('giorno_settimana', $agenda->giorno_settimana) == $k) ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
                @error('giorno_settimana') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="orario_inizio">Orario Inizio</label>
                <input type="time" name="orario_inizio" class="form-control" required value="{{ old('orario_inizio', $agenda->orario_inizio) }}">
                @error('orario_inizio') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Salva</button>
            <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
