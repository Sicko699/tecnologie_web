@extends('layouts.app')
@section('title', 'Agenda - Elenco')

@section('content')
    <div class="container mt-5">
        {{-- Intestazione --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Gestione Agende</h2>
            <a href="{{ route('admin.agende.create') }}" class="btn btn-success rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> Aggiungi Agenda
            </a>
        </div>

        {{-- Messaggi di sessione --}}
        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
        @endif

        @if($errors->has('delete'))
            <div class="alert alert-danger rounded-3 shadow-sm">{{ $errors->first('delete') }}</div>
        @endif

        {{-- Tabella --}}
        <div class="card shadow rounded-4 border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Dipartimento</th>
                            <th>Prestazione</th>
                            <th>Max Appuntamenti</th>
                            <th class="text-end">Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($agende as $agenda)
                            <tr>
                                <td>{{ $agenda->id_agenda }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $agenda->dipartimento->nome ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $agenda->prestazione->nome ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $agenda->max_appuntamenti }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                                        <a href="{{ route('admin.agende.show', $agenda) }}"
                                           class="btn btn-outline-info btn-sm rounded-pill px-3"
                                           title="Visualizza dettagli">
                                            Visualizza
                                        </a>
                                        <a href="{{ route('admin.agende.giornaliera', $agenda->id_agenda) }}"
                                           class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                                           title="Vista giornaliera">
                                            Calendario
                                        </a>
                                        <a href="{{ route('admin.agende.edit', $agenda) }}"
                                           class="btn btn-outline-warning btn-sm rounded-pill px-3"
                                           title="Modifica">
                                            Modifica
                                        </a>
                                        <form action="{{ route('admin.agende.destroy', $agenda) }}"
                                              method="POST"
                                              onsubmit="return confirm('Sei sicuro di voler eliminare questa agenda? Questa azione non può essere annullata.')"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                    title="Elimina">
                                                Elimina
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                    Nessuna agenda configurata<br>
                                    <a href="{{ route('admin.agende.create') }}" class="btn btn-primary btn-sm mt-2 rounded-pill px-3">
                                        Crea la prima agenda
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Paginazione --}}
        @if(method_exists($agende, 'links'))
            <div class="mt-3 d-flex justify-content-center">
                {{ $agende->links() }}
            </div>
        @endif

        {{-- Pulsante Indietro --}}
        <div class="mt-5 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>
@endsection
