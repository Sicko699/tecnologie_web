@extends('layouts.app')
@section('title', 'Modifica Dipartimento')

@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-building me-2 text-secondary"></i>
                Modifica Dipartimento
            </h2>
        </div>

        <div class="card p-4 shadow-sm border-0">
            <form action="{{ route('admin.dipartimenti.update', $dipartimento->id_dipartimento) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome del Dipartimento</label>
                    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $dipartimento->nome) }}" required>
                    @error('nome')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <input type="text" name="descrizione" id="descrizione" class="form-control @error('descrizione') is-invalid @enderror"
                           value="{{ old('descrizione', $dipartimento->descrizione) }}" required>
                    @error('descrizione')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-outline-secondary">
                        ← Annulla
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Salva modifiche
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
