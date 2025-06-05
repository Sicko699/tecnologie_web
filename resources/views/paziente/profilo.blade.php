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
                        <label class="form-label fw-semibold">Username</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Telefono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}">
                        @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Vecchia Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current_password">
                            <span class="password-toggle" onclick="togglePassword('current_password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        </div>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nuova Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="new_password" autocomplete="new-password">
                            <span class="password-toggle" onclick="togglePassword('new_password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        </div>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Conferma Nuova Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                            <span class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        </div>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 1.2em;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 1.18em;
            z-index: 10;
            height: 1.8em;
            display: flex;
            align-items: center;
        }
        .password-toggle:hover { color: #2b79c9; }
        @media (max-width: 600px) {
            .container {
                padding-left: 0.6em;
                padding-right: 0.6em;
            }
        }
    </style>
    <script>
        function togglePassword(fieldId, el) {
            const input = document.getElementById(fieldId);
            const icon = el.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
