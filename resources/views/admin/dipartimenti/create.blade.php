@extends('layouts.app')
@section('title', 'Nuovo Dipartimento')
@section('content')
    <div class="container">
        <h1>Aggiungi Dipartimento</h1>
        <form method="POST" action="{{ route('dipartimenti.store') }}">
            @csrf
            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descrizione</label>
                <textarea name="descrizione" class="form-control"></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Salva</button>
        </form>
    </div>
@endsection
