@extends('layouts.app')
@section('title', 'Membri Staff')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Membri Staff</h2>
            <a href="{{ route('admin.utenti.create') }}" class="btn btn-success">+ Nuovo Membro Staff</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-3">{{ session('success') }}</div>
        @endif

        <div class="card shadow rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Dipartimento</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($utenti as $utente)
                        <tr>
                            <td>{{ $utente->username }}</td>
                            <td>{{ $utente->nome }}</td>
                            <td>{{ $utente->cognome }}</td>
                            <td>{{ $utente->membroStaff?->dipartimento?->nome ?? '-' }}</td>
                            <td class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.utenti.edit', ['utenti' => $utente->codice_fiscale]) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Modifica">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.utenti.destroy', ['utenti' => $utente->codice_fiscale]) }}" method="POST"
                                      onsubmit="return confirm('Confermi eliminazione?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Elimina">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">Nessun utente disponibile.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
