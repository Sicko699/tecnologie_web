@extends('layouts.app')
@section('title', 'Statistiche')

@section('content')
    <div class="container mt-4">
        <h1>Statistiche Prestazioni</h1>

        {{-- Form di filtro --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-auto">
                <label>Dal:</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" />
            </div>
            <div class="col-auto">
                <label>Al:</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" />
            </div>
            <div class="col-auto">
                <label>Utente (opzionale):</label>
                <input type="text" name="utente_id" value="{{ request('utente_id') }}" class="form-control" placeholder="Codice Fiscale utente" />
            </div>
            <div class="col-auto d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtra</button>
            </div>
        </form>

        {{-- Grafico Prestazioni per Tipo --}}
        <h5 class="mt-5">Numero Prestazioni per Tipo</h5>
        <canvas id="prestazioniChart" height="100"></canvas>

        {{-- Grafico Prestazioni per Dipartimento --}}
        <h5 class="mt-5">Numero Prestazioni per Dipartimento</h5>
        <canvas id="dipartimentiChart" height="100"></canvas>


        {{-- Tabella Prestazioni Utente --}}
        @if($prestazioniUtente)
            <h5 class="mt-5">Prestazioni erogate all'utente CF {{ request('utente_id') }}</h5>
            <table class="table table-striped">
                <thead>
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
        @endif
    </div>

    {{-- Script per Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prestazioni totali per tipo
        const prestazioniData = {
            labels: {!! json_encode(array_keys($prestazioniCount->toArray())) !!},
            datasets: [{
                label: 'Numero Prestazioni',
                data: {!! json_encode(array_values($prestazioniCount->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
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
                        text: 'Numero Prestazioni per Tipo'
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Prestazioni totali per dipartimento
        const dipartimentiData = {
            labels: {!! json_encode(array_keys($dipartimentiCount->toArray())) !!},
            datasets: [{
                label: 'Numero Prestazioni per Dipartimento',
                data: {!! json_encode(array_values($dipartimentiCount->toArray())) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
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
                        text: 'Numero Prestazioni per Dipartimento'
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

@endsection
