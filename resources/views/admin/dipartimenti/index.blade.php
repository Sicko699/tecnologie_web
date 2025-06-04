@extends('layouts.app')
@section('title', 'Dipartimenti')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0" style="letter-spacing: .01em;">Dipartimenti</h2>
            <a href="{{ route('admin.dipartimenti.create') }}" class="btn btn-success rounded-pill px-4">+ Nuovo Dipartimento</a>
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
                        <th class="text-end">Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dipartimenti as $d)
                        <tr>
                            <td>{{ $d->id_dipartimento }}</td>
                            <td>{{ $d->nome }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.dipartimenti.edit', $d->id_dipartimento) }}"
                                       class="btn btn-outline-primary btn-sm rounded-pill px-3" title="Modifica">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.dipartimenti.destroy', $d->id_dipartimento) }}" method="POST"
                                          onsubmit="return confirm('Confermi eliminazione?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Elimina">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Nessun dipartimento disponibile.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
