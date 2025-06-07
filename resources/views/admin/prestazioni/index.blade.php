@extends('layouts.app')
@section('title', 'Prestazioni')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0"><i class="fas fa-stethoscope me-2 text-secondary"></i> Prestazioni</h2>
            <a href="{{ route('admin.prestazioni.create') }}" class="btn btn-success rounded-pill px-4">
                + Nuova Prestazione
            </a>
        </div>
        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="table-responsive" style="border-radius: 14px; overflow: hidden;">
            <table class="table table-borderless align-middle bg-white shadow-sm mb-0">
                <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Dipartimento</th>
                    <th class="text-end" style="min-width:130px;">Azioni</th>
                </tr>
                </thead>
                <tbody>
                @forelse($prestazioni as $p)
                    <tr>
                        <td>{{ $p->nome }}</td>
                        <td style="white-space: normal; word-break: break-word;">
                            {{ $p->descrizione }}
                        </td>
                        <td>{{ $p->dipartimento->nome ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.prestazioni.edit', $p->id_prestazione) }}"
                               class="btn btn-outline-primary btn-sm me-1" style="border-radius:18px;" title="Modifica">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.prestazioni.destroy', $p->id_prestazione) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Sicuro di voler eliminare questa prestazione?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius:18px;" title="Elimina">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Nessuna prestazione presente.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <style>
        .table { border-radius: 14px; overflow: hidden; }
        .btn-outline-primary, .btn-outline-danger { min-width:36px; }
        .btn-outline-primary i, .btn-outline-danger i { vertical-align: middle; }
    </style>
@endsection
