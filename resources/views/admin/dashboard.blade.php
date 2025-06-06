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
        <div class="row g-4 justify-content-center mb-5">
            {{-- Dipartimenti --}}
            <div class="col-md-2">
                <div class="card text-center shadow rounded-4 p-4 h-100">
                    <i class="fas fa-building fa-2x text-primary mb-2"></i>
                    <h5 class="fw-semibold">Dipartimenti</h5>
                    <p class="display-6 fw-bold text-dark">{{ $dipartimentiCount }}</p>
                    <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-outline-primary w-100 rounded-pill">Gestisci</a>
                </div>
            </div>

            {{-- Prestazioni --}}
            <div class="col-md-2">
                <div class="card text-center shadow rounded-4 p-4 h-100">
                    <i class="fas fa-stethoscope fa-2x text-success mb-2"></i>
                    <h5 class="fw-semibold">Prestazioni</h5>
                    <p class="display-6 fw-bold text-dark">{{ $prestazioniCount }}</p>
                    <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-outline-success w-100 rounded-pill">Gestisci</a>
                </div>
            </div>

            {{-- Utenti --}}
            <div class="col-md-2">
                <div class="card text-center shadow rounded-4 p-4 h-100">
                    <i class="fas fa-users fa-2x text-info mb-2"></i>
                    <h5 class="fw-semibold">Utenti Staff</h5>
                    <p class="display-6 fw-bold text-dark">{{ $utentiCount }}</p>
                    <a href="{{ route('admin.utenti.index') }}" class="btn btn-outline-info w-100 rounded-pill">Gestisci</a>
                </div>
            </div>

            {{-- Agenda --}}
            <div class="col-md-2">
                <div class="card text-center shadow rounded-4 p-4 h-100">
                    <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                    <h5 class="fw-semibold">Agenda</h5>
                    <p class="display-6 fw-bold text-dark">{{ $agendeCount }}</p>
                    <a href="{{ route('admin.agende.index') }}" class="btn btn-outline-warning w-100 rounded-pill">Gestisci</a>
                </div>
            </div>

            {{-- Statistiche Avanzate --}}
            <div class="col-md-2">
                <div class="card text-center shadow rounded-4 p-4 h-100">
                    <i class="fas fa-chart-line fa-2x text-secondary mb-2"></i>
                    <h5 class="fw-semibold">Statistiche Avanzate</h5>
                    <div class="mt-4">
                        <a href="{{ route('admin.statistiche.index') }}" class="btn btn-outline-secondary w-100 rounded-pill">Visualizza</a>
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
@endpush
