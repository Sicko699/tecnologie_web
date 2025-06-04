@extends('layouts.app')
@section('title', 'Aggiungi Membro Staff')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    <i class="fas fa-user-plus me-2 text-success"></i>
                    Nuovo Membro Staff
                </h2>

                <form action="{{ route('admin.utenti.store') }}" method="POST" class="p-0">
                    @csrf

                    <div class="mb-4">
                        <label for="nome" class="form-label fw-semibold">Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cognome" class="form-label fw-semibold">Cognome</label>
                        <input type="text" name="cognome" id="cognome" class="form-control @error('cognome') is-invalid @enderror" value="{{ old('cognome') }}" required>
                        @error('cognome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_dipartimento" class="form-label fw-semibold">Dipartimento</label>
                        <select name="id_dipartimento" id="id_dipartimento" class="form-select @error('id_dipartimento') is-invalid @enderror" required>
                            <option value="" disabled {{ old('id_dipartimento') ? '' : 'selected' }}>Seleziona dipartimento</option>
                            @foreach($dipartimenti as $d)
                                <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento') == $d->id_dipartimento ? 'selected' : '' }}>
                                    {{ $d->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dipartimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Conferma Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-flex gap-2 justify-content-between align-items-center pt-1">
                        <a href="{{ route('admin.utenti.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 20px;">
                            <i class="fas fa-arrow-left me-1"></i> Annulla
                        </a>
                        <button type="submit" class="btn btn-success px-4" style="border-radius: 20px;">
                            <i class="fas fa-plus-circle me-1"></i> Crea
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
            font-weight: 600;
        }
        .form-select, .form-control {
            border-radius: 12px;
            font-size: 1em;
            padding: .65em 1em;
            background: #fafbfc;
            border: 1px solid #e3e7ef;
        }
        .btn-success {
            background: #28a745;
            border: none;
            font-weight: 500;
            letter-spacing: .03em;
        }
        .btn-success:hover, .btn-success:focus {
            background: #1e7e34;
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
