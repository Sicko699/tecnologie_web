@extends('layouts.app')

@section('title', 'Dashboard Amministratore')

@section('content')
    <div class="container mt-5 mb-5">
        {{-- Intestazione --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-user-shield me-2 text-danger"></i>
                Benvenuto, Amministratore
            </h2>
        </div>

        {{-- Card Statistiche --}}
        <div class="row justify-content-center mb-5 w-100">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="dashboard-card p-0 m-2">
                        <div class="card text-center shadow rounded-4 p-4 h-100">
                            <i class="fas fa-building fa-2x text-primary mb-2"></i>
                            <h5 class="fw-semibold">Dipartimenti</h5>
                            <p class="display-6 fw-bold text-dark">{{ $dipartimentiCount }}</p>
                            <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-outline-primary w-100 rounded-pill">Gestisci</a>
                        </div>
                    </div>
                    <div class="dashboard-card p-0 m-2">
                        <div class="card text-center shadow rounded-4 p-4 h-100">
                            <i class="fas fa-stethoscope fa-2x text-success mb-2"></i>
                            <h5 class="fw-semibold">Prestazioni</h5>
                            <p class="display-6 fw-bold text-dark">{{ $prestazioniCount }}</p>
                            <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-outline-success w-100 rounded-pill">Gestisci</a>
                        </div>
                    </div>
                    <div class="dashboard-card p-0 m-2">
                        <div class="card text-center shadow rounded-4 p-4 h-100">
                            <i class="fas fa-users fa-2x text-info mb-2"></i>
                            <h5 class="fw-semibold">Membri Staff</h5>
                            <p class="display-6 fw-bold text-dark">{{ $utentiCount }}</p>
                            <a href="{{ route('admin.utenti.index') }}" class="btn btn-outline-info w-100 rounded-pill">Gestisci</a>
                        </div>
                    </div>
                    <div class="dashboard-card p-0 m-2">
                        <div class="card text-center shadow rounded-4 p-4 h-100">
                            <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                            <h5 class="fw-semibold">Agenda</h5>
                            <p class="display-6 fw-bold text-dark">{{ $agendeCount }}</p>
                            <a href="{{ route('admin.agende.index') }}" class="btn btn-outline-warning w-100 rounded-pill">Gestisci</a>
                        </div>
                    </div>
                    <div class="dashboard-card p-0 m-2">
                        <div class="card text-center shadow rounded-4 p-4 h-100">
                            <i class="fas fa-chart-line fa-2x text-secondary mb-2"></i>
                            <h5 class="fw-semibold">Statistiche Avanzate</h5>
                            <div class="mt-4">
                                <a href="{{ route('admin.statistiche.index') }}" class="btn btn-outline-secondary w-100 rounded-pill">Visualizza</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafico Appuntamenti Mensili --}}
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-white fw-semibold">
                <i class="fas fa-chart-bar me-2 text-secondary"></i> Appuntamenti Mensili
            </div>
            <div class="card-body">
                <canvas id="dashboardChart" height="80"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dashboardChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Appuntamenti fissati',
                            data: {!! json_encode($chartData) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 },
                                grid: { drawBorder: false }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>
    <style>
        .dashboard-card {
            flex: 1 1 0;
            min-width: 200px;
            max-width: 20%; /* 5 card: 20%. Se vuoi 4 card per riga metti 25%. */
            box-sizing: border-box;
            display: flex;
        }
        .dashboard-card > .card {
            width: 100%;
        }
        @media (max-width: 1200px) {
            .dashboard-card { max-width: 25%; }
        }
        @media (max-width: 992px) {
            .dashboard-card { max-width: 33.3333%; }
        }
        @media (max-width: 768px) {
            .dashboard-card { max-width: 50%; }
        }
        @media (max-width: 576px) {
            .dashboard-card { max-width: 100%; min-width: 100%; }
        }
    </style>
@endpush
