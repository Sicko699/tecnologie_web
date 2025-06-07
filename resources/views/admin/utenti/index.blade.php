@extends('layouts.app')
@section('title', 'Membri Staff')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Membri Staff</h2>
            <a href="{{ route('admin.utenti.create') }}" class="btn btn-success rounded-pill px-4">
                + Nuovo Membro Staff
            </a>
        </div>
        @if(session('success'))
            <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="table-responsive" style="border-radius: 14px; overflow: hidden;">
            <table class="table table-borderless align-middle bg-white shadow-sm mb-0">
                <thead class="table-light">
                <tr>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Dipartimento</th>
                    <th class="text-end" style="min-width:130px;">Azioni</th>
                </tr>
                </thead>
                <tbody>
                @forelse($utenti as $utente)
                    <tr>
                        <td>{{ $utente->username }}</td>
                        <td>{{ $utente->nome }}</td>
                        <td>{{ $utente->cognome }}</td>
                        <td>{{ $utente->membroStaff?->dipartimento?->nome ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.utenti.edit', ['utenti' => $utente->codice_fiscale]) }}"
                               class="btn btn-outline-primary btn-sm me-1" style="border-radius:18px;" title="Modifica">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.utenti.destroy', ['utenti' => $utente->codice_fiscale]) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Confermi eliminazione?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius:18px;" title="Elimina">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Nessun utente disponibile.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Indietro
            </a>
        </div>
    </div>
    <style>
        .table { border-radius: 14px; overflow: hidden; }
        .btn-outline-primary, .btn-outline-danger { min-width:36px; }
        .btn-outline-primary i, .btn-outline-danger i { vertical-align: middle; }
    </style>
@endsection
