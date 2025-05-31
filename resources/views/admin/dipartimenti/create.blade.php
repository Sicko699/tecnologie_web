@extends('layouts.app')
@section('title', 'Aggiungi Dipartimento')

@section('content')
    <div class="container mt-4">
        <h1>Nuovo Dipartimento</h1>
        <form action="{{ route('admin.dipartimenti.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                @error('nome') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success mt-2">Crea</button>
            <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-secondary mt-2">Annulla</a>
        </form>
    </div>
@endsection
