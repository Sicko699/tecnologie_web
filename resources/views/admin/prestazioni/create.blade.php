@extends('layouts.app')
@section('title', 'Aggiungi Prestazione')

@section('content')
    <div class="container mt-4">
        <h1>Nuova Prestazione</h1>
        <form action="{{ route('admin.prestazioni.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                @error('nome') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mt-2">
                <label for="id_dipartimento">Dipartimento</label>
                <select name="id_dipartimento" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento') == $d->id_dipartimento ? 'selected' : '' }}>{{ $d->nome }}</option>
                    @endforeach
                </select>
                @error('id_dipartimento') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success mt-2">Crea</button>
            <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
