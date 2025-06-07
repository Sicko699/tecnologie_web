@extends('layouts.app')
@section('title', 'Modifica Prestazione')

@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <h2 class="fw-bold">
                <i class="fas fa-stethoscope me-2 text-secondary"></i>
                Modifica Prestazione
            </h2>
        </div>

        <div class="card p-4 shadow-sm border-0">
            <form action="{{ route('admin.prestazioni.update', $prestazione->id_prestazione) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome della Prestazione</label>
                    <input type="text" name="nome" id="nome"
                           class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $prestazione->nome) }}" required>
                    @error('nome')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <input type="text" name="descrizione" id="descrizione"
                           class="form-control @error('descrizione') is-invalid @enderror"
                           value="{{ old('descrizione', $prestazione->descrizione) }}" required>
                    @error('descrizione')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_dipartimento" class="form-label">Dipartimento</label>
                    <select name="id_dipartimento" id="id_dipartimento"
                            class="form-select @error('id_dipartimento') is-invalid @enderror" required>
                        <option value="">Seleziona un dipartimento</option>
                        @foreach($dipartimenti as $d)
                            <option value="{{ $d->id_dipartimento }}"
                                {{ old('id_dipartimento', $prestazione->id_dipartimento) == $d->id_dipartimento ? 'selected' : '' }}>
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
                        <i class="fas fa-save me-1"></i> Salva modifiche
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
