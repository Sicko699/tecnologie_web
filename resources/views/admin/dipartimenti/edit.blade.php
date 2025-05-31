@extends('layouts.app')
@section('title', 'Modifica Dipartimento')

@section('content')
    <div class="container mt-4">
        <h1>Modifica Dipartimento</h1>
        <form action="{{ route('admin.dipartimenti.update', ['dipartimenti' => $dipartimento->id_dipartimento]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ old('nome', $dipartimento->nome) }}" required>
                @error('nome')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Salva</button>
            <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
