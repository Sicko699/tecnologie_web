@extends('layouts.app')
@section('title', 'Statistiche')

@section('content')
    <div class="container mt-5 mb-5">
        <h2 class="fw-bold text-primary mb-4">Statistiche Prestazioni</h2>

        <div class="card shadow rounded-4 mb-5">
            <div class="card-body">
                <form id="statistiche-form" class="row g-4 align-items-end">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label fw-semibold">Dal</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label fw-semibold">Al</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" />
                    </div>
                    <div class="col-md-2">
                        <label for="nome" class="form-label fw-semibold">Nome Utente</label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" />
                    </div>
                    <div class="col-md-2">
                        <label for="cognome" class="form-label fw-semibold">Cognome Utente</label>
                        <input type="text" id="cognome" name="cognome" class="form-control" placeholder="Cognome" />
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Filtra</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow rounded-4 mb-5">
            <div class="card-header bg-primary text-white fw-bold">
                Numero Prestazioni per Tipo
            </div>
            <div class="card-body">
                <canvas id="prestazioniChart" height="120"></canvas>
            </div>
        </div>

        <div class="card shadow rounded-4 mb-5">
            <div class="card-header bg-primary text-white fw-bold">
                Numero Prestazioni per Dipartimento
            </div>
            <div class="card-body">
                <canvas id="dipartimentiChart" height="120"></canvas>
            </div>
        </div>

        <div id="utente-results"></div>

        <div class="mt-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let prestazioniChart, dipartimentiChart;

        function renderChart(canvasId, chartRef, labels, data, title) {
            if (chartRef) chartRef.destroy();
            return new Chart(document.getElementById(canvasId), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.75)',
                        borderRadius: 6,
                        barPercentage: 0.7,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: title,
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
        }

        function renderUtenteTable(prestazioniUtente, nome, cognome) {
            if (!prestazioniUtente || prestazioniUtente.length === 0) {
                $('#utente-results').html('');
                return;
            }
            let rows = prestazioniUtente.map(p =>
                `<tr>
                    <td>${p.data ?? '-'}</td>
                    <td>${p.richiesta?.prestazione?.nome ?? '-'}</td>
                    <td>${p.richiesta?.dipartimento?.nome ?? '-'}</td>
                    <td>${p.stato ?? '-'}</td>
                </tr>`
            ).join('');
            $('#utente-results').html(`
                <div class="card shadow rounded-4 mb-5">
                    <div class="card-header bg-info text-white fw-bold">
                        Prestazioni erogate all'utente: <b>${nome} ${cognome}</b>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Data</th>
                                        <th>Prestazione</th>
                                        <th>Dipartimento</th>
                                        <th>Stato</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `);
        }

        // Prima renderizzazione con i dati blade
        $(function() {
            prestazioniChart = renderChart(
                'prestazioniChart',
                prestazioniChart,
                {!! json_encode(array_keys($prestazioniCount->toArray())) !!},
                {!! json_encode(array_values($prestazioniCount->toArray())) !!},
                'Numero Prestazioni per Tipo'
            );
            dipartimentiChart = renderChart(
                'dipartimentiChart',
                dipartimentiChart,
                {!! json_encode(array_keys($dipartimentiCount->toArray())) !!},
                {!! json_encode(array_values($dipartimentiCount->toArray())) !!},
                'Numero Prestazioni per Dipartimento'
            );
        });

        // Submit AJAX
        $('#statistiche-form').on('submit', function(e) {
            e.preventDefault();
            let nome = $('#nome').val();
            let cognome = $('#cognome').val();

            $.ajax({
                url: "{{ route('admin.statistiche.index') }}",
                method: "GET",
                data: $(this).serialize(),
                success: function(data) {
                    // Aggiorna i grafici
                    prestazioniChart = renderChart(
                        'prestazioniChart',
                        prestazioniChart,
                        Object.keys(data.prestazioniCount),
                        Object.values(data.prestazioniCount),
                        'Numero Prestazioni per Tipo'
                    );
                    dipartimentiChart = renderChart(
                        'dipartimentiChart',
                        dipartimentiChart,
                        Object.keys(data.dipartimentiCount),
                        Object.values(data.dipartimentiCount),
                        'Numero Prestazioni per Dipartimento'
                    );

                    // Aggiorna tabella utente se presente
                    renderUtenteTable(data.prestazioniUtente, nome, cognome);
                },
                error: function(xhr) {
                    alert('Errore nella ricerca');
                }
            });
        });
    </script>
@endsection
