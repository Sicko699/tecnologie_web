@extends('layouts.app')
@section('title', 'Prestazioni')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0" style="letter-spacing: .01em;">Prestazioni</h2>
            <a href="{{ route('admin.prestazioni.create') }}" class="btn btn-success rounded-pill px-4">+ Nuova Prestazione</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card shadow rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Dipartimento</th>
                        <th class="text-end">Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($prestazioni as $p)
                        <tr>
                            <td>{{ $p->id_prestazione }}</td>
                            <td>{{ $p->nome }}</td>
                            <td>{{ $p->dipartimento->nome ?? '-' }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.prestazioni.edit', $p->id_prestazione) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.prestazioni.destroy', $p->id_prestazione) }}" method="POST"
                                          onsubmit="return confirm('Confermi eliminazione?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Elimina">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Nessuna prestazione disponibile.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
