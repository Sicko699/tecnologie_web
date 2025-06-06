@extends('layouts.app')
@section('title', 'Modifica Dipartimento')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card shadow rounded-4">
            <div class="card-body">
                <h2 class="card-title mb-4">Modifica Dipartimento</h2>

                <form action="{{ route('admin.dipartimenti.update', $dipartimento->id_dipartimento) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome', $dipartimento->nome) }}" required>
                        @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-secondary">Annulla</a>
                        <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
