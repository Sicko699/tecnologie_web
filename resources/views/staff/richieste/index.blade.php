@extends('layouts.app')
@section('title', 'Richieste Pendenti')

@section('content')
    <style>
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .custom-table {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .no-data {
            padding: 2rem;
            color: #6c757d;
        }
    </style>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-hourglass-half text-warning me-2"></i>
                Richieste in Attesa
            </h2>
        </div>

        <div class="table-responsive custom-table">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th><i class="fas fa-user me-1 text-secondary"></i> Utente</th>
                    <th><i class="fas fa-stethoscope me-1 text-secondary"></i> Prestazione</th>
                    <th><i class="fas fa-info-circle me-1 text-secondary"></i> Stato</th>
                    <th><i class="fas fa-tools me-1 text-secondary"></i> Azioni</th>
                </tr>
                </thead>
                <tbody>
                @forelse($richieste as $richiesta)
                    <tr>
                        <td>{{ $richiesta->utente->nome }} {{ $richiesta->utente->cognome }}</td>
                        <td>{{ $richiesta->prestazione->nome ?? '-' }}</td>
                        <td>
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($richiesta->stato) }}
                                </span>
                        </td>
                        <td>
                            <a href="{{ route('staff.appuntamenti.create', $richiesta->id_richiesta) }}"
                               class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-calendar-plus me-1"></i> Assegna appuntamento
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center no-data">
                            <i class="fas fa-inbox me-2"></i> Nessuna richiesta in attesa
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
