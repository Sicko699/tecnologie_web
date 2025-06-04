@extends('layouts.app')
@section('title', 'Modifica Appuntamento')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h2 class="fw-bold mb-4 text-center">
                    <i class="fas fa-edit me-2 text-warning"></i> Modifica Appuntamento
                </h2>

                <form method="POST" action="{{ route('staff.appuntamenti.update', ['appuntamento' => $appuntamento->id_appuntamento]) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" name="data" class="form-control" value="{{ $appuntamento->data }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ora" class="form-label">Ora</label>
                        <input type="time" name="ora" class="form-control" value="{{ $appuntamento->ora }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="stato" class="form-label">Stato</label>
                        <select name="stato" class="form-select">
                            <option value="prenotato" {{ $appuntamento->stato == 'prenotato' ? 'selected' : '' }}>Prenotato</option>
                            <option value="erogato" {{ $appuntamento->stato == 'erogato' ? 'selected' : '' }}>Erogato</option>
                            <option value="annullato" {{ $appuntamento->stato == 'annullato' ? 'selected' : '' }}>Annullato</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('staff.appuntamenti.index') }}" class="btn btn-outline-secondary">Annulla</a>
                        <button type="submit" class="btn btn-success rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> Salva modifiche
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
