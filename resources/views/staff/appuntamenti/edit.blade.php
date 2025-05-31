@extends('layouts.app')
@section('title', 'Modifica Appuntamento')

@section('content')
    <div class="container mt-4">
        <h1>Modifica Appuntamento</h1>
        <form action="{{ route('staff.appuntamenti.update', ['appuntamento' => $appuntamento->id_appuntamento]) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" name="data" class="form-control" value="{{ $appuntamento->data }}" required>
            </div>
            <div class="form-group">
                <label for="ora">Ora</label>
                <input type="time" name="ora" class="form-control" value="{{ $appuntamento->ora }}" required>
            </div>
            <div class="form-group">
                <label for="stato">Stato</label>
                <select name="stato" class="form-control">
                    <option value="prenotato" {{ $appuntamento->stato == 'prenotato' ? 'selected' : '' }}>Prenotato</option>
                    <option value="erogato" {{ $appuntamento->stato == 'erogato' ? 'selected' : '' }}>Erogato</option>
                    <option value="annullato" {{ $appuntamento->stato == 'annullato' ? 'selected' : '' }}>Annullato</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Salva</button>
            <a href="{{ route('staff.appuntamenti.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
