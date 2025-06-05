@extends('layouts.app')
@section('title', 'Dashboard Staff')

@section('content')
    <style>
        .card-dashboard {
            border-radius: 1rem;
            background: white;
            color: #333;
            border: 2px solid transparent;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
        }

        .card-dashboard .icon {
            font-size: 2.4rem;
            margin-bottom: 0.8rem;
        }

        .btn-dashboard {
            border-radius: 30px;
            font-weight: 500;
        }

        /* Colori bordo */
        .bordo-azzurro { border-color: #00bcd4; }
        .bordo-verde { border-color: #4caf50; }
        .bordo-arancio { border-color: #ff9800; }
        .bordo-viola { border-color: #9c27b0; }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">
                <i class="fas fa-user-nurse me-2 text-info"></i>
                Benvenuto, membro dello Staff
            </h2>
        </div>

        <div class="row justify-content-center g-4">
            <!-- Appuntamenti -->
            <div class="col-md-3">
                <div class="card card-dashboard bordo-azzurro text-center p-4">
                    <i class="fas fa-calendar-check icon text-azzurro"></i>
                    <h5 class="fw-semibold">Appuntamenti</h5>
                    <a href="{{ route('staff.appuntamenti.index') }}" class="btn btn-outline-info btn-dashboard mt-3 w-100">Visualizza</a>
                </div>
            </div>

            <!-- Prestazioni -->
            <div class="col-md-3">
                <div class="card card-dashboard bordo-verde text-center p-4">
                    <i class="fas fa-tools icon text-success"></i>
                    <h5 class="fw-semibold">Prestazioni</h5>
                    <a href="{{ route('staff.prestazioni.index') }}" class="btn btn-outline-success btn-dashboard mt-3 w-100">Gestisci</a>
                </div>
            </div>

            <!-- Richieste -->
            <div class="col-md-3">
                <div class="card card-dashboard bordo-arancio text-center p-4">
                    <i class="fas fa-envelope-open-text icon text-warning"></i>
                    <h5 class="fw-semibold">Richieste</h5>
                    <a href="{{ route('staff.richieste.index') }}" class="btn btn-outline-warning btn-dashboard mt-3 w-100">Gestisci</a>
                </div>
            </div>

            <!-- Agenda -->
            <div class="col-md-3">
                <div class="card card-dashboard bordo-viola text-center p-4">
                    <i class="fas fa-calendar-day icon" style="color: #9c27b0;"></i>
                    <h5 class="fw-semibold">Agenda</h5>
                    <a href="{{ route('staff.agenda.giornaliera') }}" class="btn btn-outline-secondary btn-dashboard mt-3 w-100">Visualizza</a>
                </div>
            </div>
        </div>
    </div>
@endsection
