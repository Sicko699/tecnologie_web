@extends('layouts.app')
@section('title', 'Agenda - Elenco')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Gestione Agende</h2>
            <a href="{{ route('admin.agende.create') }}" class="btn btn-success rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> Aggiungi Agenda
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
        @endif
        @if($errors->has('delete'))
            <div class="alert alert-danger rounded-3 shadow-sm">{{ $errors->first('delete') }}</div>
        @endif

        <div class="table-responsive" style="border-radius: 14px; overflow: hidden;">
            <table class="table table-borderless align-middle bg-white shadow-sm mb-0" style="border-radius:14px;">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Dipartimento</th>
                    <th>Prestazione</th>
                    <th>Max Appuntamenti</th>
                    <th class="text-end" style="min-width:130px;">Azioni</th>
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
                            <a href="{{ route('admin.agende.show', $agenda) }}"
                               class="btn btn-outline-info btn-sm me-1" style="border-radius:18px;" title="Visualizza dettagli">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.agende.edit', $agenda) }}"
                               class="btn btn-outline-primary btn-sm me-1" style="border-radius:18px;" title="Modifica">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.agende.destroy', $agenda) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Sei sicuro di voler eliminare questa agenda? Questa azione non può essere annullata.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius:18px;" title="Elimina">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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

        @if(method_exists($agende, 'links'))
            <div class="mt-3 d-flex justify-content-center">
                {{ $agende->links() }}
            </div>
        @endif

        <div class="mt-5 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>
    <style>
        .table { border-radius: 14px; overflow: hidden; }
        .btn-outline-primary, .btn-outline-danger, .btn-outline-info { min-width:36px; }
        .btn-outline-primary i, .btn-outline-danger i, .btn-outline-info i { vertical-align: middle; }
    </style>
@endsection
