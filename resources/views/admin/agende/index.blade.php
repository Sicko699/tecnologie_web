@extends('layouts.app')
@section('title', 'Agenda - Elenco')

@section('content')
    <div class="container mt-4">
        <h1>Gestione Agende</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('delete'))
            <div class="alert alert-danger">
                {{ $errors->first('delete') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.agende.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Aggiungi Agenda
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Dipartimento</th>
                    <th>Prestazione</th>
                    <th>Max Appuntamenti</th>
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                @forelse($agende as $agenda)
                    <tr>
                        <td>{{ $agenda->id_agenda }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $agenda->dipartimento->nome ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $agenda->prestazione->nome ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-success">{{ $agenda->max_appuntamenti }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.agende.show', $agenda) }}"
                                   class="btn btn-info btn-sm"
                                   title="Visualizza dettagli">
                                    Visualizza
                                </a>
                                <a href="{{ route('admin.agende.giornaliera', $agenda->id_agenda) }}"
                                   class="btn btn-secondary btn-sm"
                                   title="Vista giornaliera">
                                    Calendario
                                </a>
                                <a href="{{ route('admin.agende.edit', $agenda) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Modifica">
                                    Modifica
                                </a>
                                <form action="{{ route('admin.agende.destroy', $agenda) }}"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Sei sicuro di voler eliminare questa agenda? Questa azione non può essere annullata.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Elimina">
                                        Elimina
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <br>
                            Nessuna agenda configurata
                            <br>
                            <a href="{{ route('admin.agende.create') }}" class="btn btn-primary btn-sm mt-2">
                                Crea la prima agenda
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginazione, se necessaria --}}
        @if(method_exists($agende, 'links'))
            <div class="mt-3 d-flex justify-content-center">
                {{ $agende->links() }}
            </div>
        @endif
    </div>

    <style>
        .d-flex {
            flex-wrap: wrap;
        }
        .table th {
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection
