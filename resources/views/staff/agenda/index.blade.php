@extends('layouts.app')
@section('title', 'Agende - Elenco')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Agende disponibili</h2>
        <div class="table-responsive" style="border-radius: 14px; overflow: hidden;">
            <table class="table table-borderless align-middle bg-white shadow-sm mb-0" style="border-radius:14px;">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Dipartimento</th>
                    <th>Prestazione</th>
                    <th>Max Appuntamenti</th>
                    <th class="text-end">Dettagli</th>
                </tr>
                </thead>
                <tbody>
                @forelse($agende as $agenda)
                    <tr>
                        <td>{{ $agenda->id_agenda }}</td>
                        <td>{{ $agenda->dipartimento->nome ?? 'N/A' }}</td>
                        <td>{{ $agenda->prestazione->nome ?? 'N/A' }}</td>
                        <td>{{ $agenda->max_appuntamenti }}</td>
                        <td class="text-end">
                            <a href="{{ route('staff.agenda.show', $agenda) }}"
                               class="btn btn-outline-info btn-sm me-1" style="border-radius:18px;" title="Visualizza dettagli">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                            Nessuna agenda configurata
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5 mb-5">
            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>
@endsection
