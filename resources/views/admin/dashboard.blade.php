@extends('layouts.app')
@section('title', 'Dashboard Amministratore')

@section('content')
    <div class="container mt-4">
        <h1>Benvenuto nella Dashboard Admin</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Dipartimenti</h5>
                        <p class="card-text display-4">{{ $dipartimentiCount }}</p>
                        <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Prestazioni</h5>
                        <p class="card-text display-4">{{ $prestazioniCount }}</p>
                        <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Utenti Staff</h5>
                        <p class="card-text display-4">{{ $utentiCount }}</p>
                        <a href="{{ route('admin.utenti.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Agenda</h5>
                        <p class="card-text display-4">{{ $agendeCount }}</p>
                        <a href="{{ route('admin.agende.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafico dinamico --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        Prestazioni Mensili (Appuntamenti)
                    </div>
                    <div class="card-body">
                        <canvas id="dashboardChart" height="60"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Link utili --}}
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('admin.statistiche.index') }}" class="btn btn-outline-primary">Vai alle Statistiche avanzate</a>
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
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        });
    </script>
@endpush
