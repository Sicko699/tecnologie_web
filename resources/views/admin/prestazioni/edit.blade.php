@extends('layouts.app')
@section('title', 'Modifica Prestazione')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card shadow rounded-4">
            <div class="card-body">
                <h2 class="card-title mb-4">
                    <i class="fas fa-edit me-2 text-primary"></i>
                    Modifica Prestazione
                </h2>

                <form action="{{ route('admin.prestazioni.update', ['prestazioni' => $prestazione->id_prestazione]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome', $prestazione->nome) }}" required>
                        @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_dipartimento" class="form-label">Dipartimento</label>
                        <select name="id_dipartimento" id="id_dipartimento" class="form-select @error('id_dipartimento') is-invalid @enderror" required>
                            <option value="" disabled {{ old('id_dipartimento', $prestazione->id_dipartimento) ? '' : 'selected' }}>Seleziona</option>
                            @foreach($dipartimenti as $d)
                                <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento', $prestazione->id_dipartimento) == $d->id_dipartimento ? 'selected' : '' }}>
                                    {{ $d->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dipartimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-secondary">Annulla</a>
                        <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
