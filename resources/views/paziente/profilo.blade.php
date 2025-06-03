@extends('layouts.app')
@section('title', 'Profilo Utente')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    Profilo di {{ Auth::user()->nome }} {{ Auth::user()->cognome }}
                </h2>
                <form method="POST" action="{{ route('paziente.profilo.update') }}" class="p-0">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome', Auth::user()->nome) }}">
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Cognome</label>
                        <input type="text" class="form-control @error('cognome') is-invalid @enderror" name="cognome" value="{{ old('cognome', Auth::user()->cognome) }}">
                        @error('cognome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Telefono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}">
                        @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-between align-items-center pt-1">
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 20px;">
                            Salva modifiche
                        </button>
                        <a href="{{ route('paziente.dashboard') }}" class="btn btn-link text-muted px-2" style="text-decoration:none;">
                            Indietro
                        </a>
                    </div>
                </form>
                <form method="POST" action="{{ route('paziente.account.delete') }}" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100" onclick="return confirm('Sei sicuro di voler eliminare il tuo account?');">
                        Elimina Account
                    </button>
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
        .btn-link {
            color: #888;
            font-weight: 400;
        }
        .btn-link:hover {
            color: #222;
        }
        .btn-outline-danger {
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
