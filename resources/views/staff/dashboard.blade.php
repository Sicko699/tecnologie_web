@extends('layouts.app')
@section('title', 'Dashboard Staff')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-user-nurse me-2 text-info"></i>
                Benvenuto, membro dello Staff
            </h2>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card text-center p-4 border-0 shadow" style="background: #f9f9f9;">
                    <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                    <h5 class="fw-semibold">Appuntamenti Assegnati</h5>
                    <a href="{{ route('staff.appuntamenti.index') }}" class="btn btn-outline-primary w-100 mt-2">Visualizza</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4 border-0 shadow" style="background: #f9f9f9;">
                    <i class="fas fa-tools fa-2x text-success mb-2"></i>
                    <h5 class="fw-semibold">Gestione Prestazioni</h5>
                    <a href="{{ route('staff.prestazioni.index') }}" class="btn btn-outline-success w-100 mt-2">Gestisci</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4 border-0 shadow" style="background: #f9f9f9;">
                    <i class="fas fa-envelope-open-text fa-2x text-warning mb-2"></i>
                    <h5 class="fw-semibold">Richieste Pendenti</h5>
                    <a href="{{ route('staff.richieste.index') }}" class="btn btn-outline-warning w-100 mt-2">Gestisci</a>
                </div>
            </div>
        </div>
    </div>
@endsection
