@extends('layouts.app')
@section('title', 'Modifica Utente')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    <i class="fas fa-user-edit me-2 text-primary"></i>
                    Modifica Utente Staff/Admin
                </h2>

                <form action="{{ route('admin.utenti.update', ['utenti' => $utente->codice_fiscale]) }}" method="POST" class="p-0">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $utente->nome) }}" required>
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="cognome">Cognome</label>
                        <input type="text" id="cognome" name="cognome" class="form-control @error('cognome') is-invalid @enderror" value="{{ old('cognome', $utente->cognome) }}" required>
                        @error('cognome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $utente->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="id_dipartimento">Dipartimento</label>
                        <select id="id_dipartimento" name="id_dipartimento" class="form-select @error('id_dipartimento') is-invalid @enderror" required>
                            <option value="" disabled {{ old('id_dipartimento', $utente->membroStaff?->id_dipartimento) ? '' : 'selected' }}>Seleziona dipartimento</option>
                            @foreach($dipartimenti as $d)
                                <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento', $utente->membroStaff?->id_dipartimento) == $d->id_dipartimento ? 'selected' : '' }}>
                                    {{ $d->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dipartimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-between align-items-center pt-1">
                        <a href="{{ route('admin.utenti.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 20px;">
                            <i class="fas fa-arrow-left me-1"></i> Annulla
                        </a>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 20px;">
                            <i class="fas fa-save me-1"></i> Salva modifiche
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .form-label {
            font-size: 1.05em;
            margin-bottom: .3em;
        }
        .form-select, .form-control {
            border-radius: 12px;
            font-size: 1em;
            padding: .65em 1em;
            background: #fafbfc;
            border: 1px solid #e3e7ef;
        }
        .btn-primary {
            background: #2b79c9;
            border: none;
            font-weight: 500;
            letter-spacing: .03em;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #185f9e;
        }
        .btn-outline-secondary {
            border-radius: 20px;
        }
        @media (max-width: 600px) {
            .container {
                padding-left: 0.6em;
                padding-right: 0.6em;
            }
        }
    </style>
@endsection
