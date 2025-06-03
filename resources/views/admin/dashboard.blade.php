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
                        <p class="card-text display-4">{{ $dipartimentiCount ?? '-' }}</p>
                        <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Prestazioni</h5>
                        <p class="card-text display-4">{{ $prestazioniCount ?? '-' }}</p>
                        <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Utenti Staff/Admin</h5>
                        <p class="card-text display-4">{{ $utentiCount ?? '-' }}</p>
                        <a href="{{ route('admin.utenti.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
            <!-- Qui la card modificata -->
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Agenda Slot</h5>
                        <p class="card-text display-4">{{ $agendeCount ?? '-' }}</p>
                        <a href="{{ route('admin.agende.index') }}" class="btn btn-light btn-sm">Gestisci</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Esempio di grafico (placeholder) --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        Statistiche Mensili (esempio)
                    </div>
                    <div class="card-body">
                        <canvas id="dashboardChart" height="60"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('admin.statistiche.index') }}" class="btn btn-outline-primary">Vai alle Statistiche avanzate</a>
{{--                <a href="{{ route('admin.agende.index') }}" class="btn btn-outline-secondary">Gestisci Agenda Slot</a>--}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Se vuoi usare chart.js per il grafico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('dashboardChart');
            if(ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartLabels ?? ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu']) !!},
                        datasets: [{
                            label: 'Prestazioni erogate',
                            data: {!! json_encode($chartData ?? [0,0,0,0,0,0]) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        });
    </script>
@endpush
