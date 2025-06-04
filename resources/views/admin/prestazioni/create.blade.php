@extends('layouts.app')
@section('title', 'Aggiungi Prestazione')

@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-stethoscope me-2 text-secondary"></i>
                Nuova Prestazione
            </h2>
        </div>

        <div class="card p-4 shadow-sm border-0">
            <form action="{{ route('admin.prestazioni.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
                    @error('nome')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_dipartimento" class="form-label">Dipartimento</label>
                    <select name="id_dipartimento" id="id_dipartimento" class="form-select" required>
                        <option value="" disabled {{ old('id_dipartimento') ? '' : 'selected' }}>Seleziona</option>
                        @foreach($dipartimenti as $d)
                            <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento') == $d->id_dipartimento ? 'selected' : '' }}>
                                {{ $d->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_dipartimento')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-outline-secondary">
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
