@extends('layouts.app')
@section('title', 'Statistiche')

@section('content')
    <div class="container mt-5 mb-5">
        {{-- Titolo --}}
        <h2 class="fw-bold text-primary mb-4">Statistiche Prestazioni</h2>

        {{-- Filtro --}}
        <div class="card shadow rounded-4 mb-5">
            <div class="card-body">
                <form method="GET" class="row g-4 align-items-end">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label fw-semibold">Dal</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label fw-semibold">Al</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="form-control" />
                    </div>
                    <div class="col-md-4">
                        <label for="utente_id" class="form-label fw-semibold">Utente (opzionale)</label>
                        <input type="text" id="utente_id" name="utente_id" value="{{ request('utente_id') }}" class="form-control" placeholder="Codice Fiscale" />
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Filtra</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grafico Prestazioni per Tipo --}}
        <div class="card shadow rounded-4 mb-5">
            <div class="card-header bg-primary text-white fw-bold">
                Numero Prestazioni per Tipo
            </div>
            <div class="card-body">
                <canvas id="prestazioniChart" height="120"></canvas>
            </div>
        </div>

        {{-- Grafico Prestazioni per Dipartimento --}}
        <div class="card shadow rounded-4 mb-5">
            <div class="card-header bg-primary text-white fw-bold">
                Numero Prestazioni per Dipartimento
            </div>
            <div class="card-body">
                <canvas id="dipartimentiChart" height="120"></canvas>
            </div>
        </div>

        {{-- Tabella Prestazioni Utente --}}
        @if($prestazioniUtente)
            <div class="card shadow rounded-4 mb-5">
                <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center">
                    <span>Prestazioni erogate all'utente CF: <code>{{ request('utente_id') }}</code></span>
                    <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-light btn-sm rounded-pill">Torna a Prestazioni</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>ID Appuntamento</th>
                                <th>Prestazione</th>
                                <th>Dipartimento</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prestazioniUtente as $p)
                                <tr>
                                    <td>{{ $p->id_appuntamento }}</td>
                                    <td>{{ $p->richiesta->prestazione->nome ?? '-' }}</td>
                                    <td>{{ $p->richiesta->dipartimento->nome ?? '-' }}</td>
                                    <td>{{ $p->data ?? '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- Pulsante Indietro --}}
        <div class="mt-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const prestazioniData = {
            labels: {!! json_encode(array_keys($prestazioniCount->toArray())) !!},
            datasets: [{
                label: 'Numero Prestazioni',
                data: {!! json_encode(array_values($prestazioniCount->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.75)',
                borderRadius: 6,
                barPercentage: 0.7,
                borderSkipped: false
            }]
        };

        new Chart(document.getElementById('prestazioniChart'), {
            type: 'bar',
            data: prestazioniData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Numero Prestazioni per Tipo',
                        font: { size: 18 }
                    },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { drawBorder: false },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        const dipartimentiData = {
            labels: {!! json_encode(array_keys($dipartimentiCount->toArray())) !!},
            datasets: [{
                label: 'Numero Prestazioni per Dipartimento',
                data: {!! json_encode(array_values($dipartimentiCount->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.75)',
                borderRadius: 6,
                barPercentage: 0.7,
                borderSkipped: false
            }]
        };

        new Chart(document.getElementById('dipartimentiChart'), {
            type: 'bar',
            data: dipartimentiData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Numero Prestazioni per Dipartimento',
                        font: { size: 18 }
                    },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { drawBorder: false },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
@endsection
