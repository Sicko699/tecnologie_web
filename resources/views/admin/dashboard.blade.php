@extends('layouts.app')
@section('title', 'Dashboard Amministratore')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Benvenuto, {{ Auth::user()->nome }}</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        {{-- Cards riepilogative --}}
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Dipartimenti</h5>
                        <p class="display-5">{{ $dipartimentiCount ?? '-' }}</p>
                        <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-outline-primary">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Prestazioni</h5>
                        <p class="display-5">{{ $prestazioniCount ?? '-' }}</p>
                        <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-outline-success">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Membri Staff</h5>
                        <p class="display-5">{{ $utentiCount ?? '-' }}</p>
                        <a href="{{ route('admin.utenti.index') }}" class="btn btn-outline-info">Gestisci</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafico statistiche --}}
        <div class="row mb-4">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        Statistiche Mensili
                    </div>
                    <div class="card-body">
                        <canvas id="dashboardChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Collegamenti rapidi --}}
        <div class="row">
            <div class="col text-center">
                <a href="{{ route('admin.statistiche.index') }}" class="btn btn-outline-dark mx-2">Statistiche Avanzate</a>
                <a href="{{ route('admin.agende.index') }}" class="btn btn-outline-secondary mx-2">Gestisci Agenda</a>
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
                        labels: {!! json_encode($chartLabels ?? ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu']) !!},
                        datasets: [{
                            label: 'Prestazioni erogate',
                            data: {!! json_encode($chartData ?? [0, 0, 0, 0, 0, 0]) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }
        });
    </script>
@endpush
