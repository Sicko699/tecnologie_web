{{-- resources/views/login.blade.php --}}
@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">
                    Accedi
                </h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                        @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password" required>
                            <span class="password-toggle" onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        </div>
                        @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary px-4 w-100" style="border-radius: 20px;">Accedi</button>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .form-label { font-size: 1.05em; margin-bottom: .3em; }
        .form-select, .form-control {
            border-radius: 12px; font-size: 1em;
            padding: .65em 1em; background: #fafbfc; border: 1px solid #e3e7ef;
        }
        .btn-primary {
            background: #2b79c9; border: none;
            font-weight: 500; letter-spacing: .03em;
        }
        .btn-primary:hover, .btn-primary:focus { background: #185f9e; }
        .password-toggle {
            position: absolute; top: 50%; right: 1.2em; transform: translateY(-50%);
            cursor: pointer; color: #888; font-size: 1.18em; z-index: 10;
            height: 1.8em; display: flex; align-items: center;
        }
        .password-toggle:hover { color: #2b79c9; }
        @media (max-width: 600px) {
            .container { padding-left: 0.6em; padding-right: 0.6em; }
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
