@extends('layouts.app')
@section('title', 'Le tue richieste')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4 text-center">Le tue richieste</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('paziente.prenotazioni.create') }}" class="btn btn-primary" style="border-radius:20px;">
                + Nuova Richiesta
            </a>
        </div>
        @if($prenotazioni->count())
            <div class="table-responsive">
                <table class="table table-borderless align-middle bg-white shadow-sm" style="border-radius:14px;">
                    <thead>
                    <tr>
                        <th>Prestazione</th>
                        <th>Dipartimento</th>
                        <th>Giorno escluso</th>
                        <th>Stato</th>
                        <th class="text-end">Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prenotazioni as $pren)
                        <tr>
                            <td>{{ $pren->prestazione->nome ?? '-' }}</td>
                            <td>{{ $pren->prestazione->dipartimento->nome ?? '-' }}</td>
                            <td>{{ $pren->giorno_escluso ?: '-' }}</td>
                            <td>
                            <span class="badge rounded-pill {{ $pren->stato == 'in attesa' ? 'bg-warning' : ($pren->stato == 'accettata' ? 'bg-success' : 'bg-secondary') }}">
                                {{ ucfirst($pren->stato) }}
                            </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('paziente.prenotazioni.show', $pren->id_richiesta) }}" class="btn btn-outline-info btn-sm me-1" title="Visualizza" style="border-radius:18px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('paziente.prenotazioni.edit', $pren->id_richiesta) }}" class="btn btn-outline-primary btn-sm me-1" title="Modifica" style="border-radius:18px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('paziente.prenotazioni.destroy', $pren->id_richiesta) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Elimina" style="border-radius:18px;" onclick="return confirm('Eliminare questa prenotazione?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-5">
                <p class="mb-0">Nessuna richiesta trovata.</p>
            </div>
        @endif
    </div>
    <style>
        .table { border-radius: 14px; overflow: hidden; }
        .badge { font-size: 1em; }
        .btn-outline-primary, .btn-outline-danger, .btn-outline-info { min-width:36px; }
        .btn-outline-primary i, .btn-outline-danger i, .btn-outline-info i { vertical-align: middle; }
    </style>
@endsection
