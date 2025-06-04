@extends('layouts.app')
@section('title', 'Aggiungi Dipartimento')

@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-building me-2 text-secondary"></i>
                Nuovo Dipartimento
            </h2>
        </div>

        <div class="card p-4 shadow-sm border-0">
            <form action="{{ route('admin.dipartimenti.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome del Dipartimento</label>
                    <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                    @error('nome')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-outline-secondary">
                        ← Annulla
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Crea
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
