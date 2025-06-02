@extends('layouts.app')
@section('title', 'Richieste Pendenti')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Richieste in attesa</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Utente</th>
                    <th>Prestazione</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($richieste as $richiesta)
                    <tr>
                        <td>{{ $richiesta->utente->nome }} {{ $richiesta->utente->cognome }}</td>
                        <td>{{ $richiesta->prestazione->nome ?? '-' }}</td>
                        <td>{{ ucfirst($richiesta->stato) }}</td>
                        <td>
                            <a href="{{ route('staff.appuntamenti.create', $richiesta->id_richiesta) }}"
                               class="btn btn-primary btn-sm rounded-pill">
                                Assegna appuntamento
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($richieste) === 0)
                <div class="text-center text-muted py-4">
                    Nessuna richiesta in attesa
                </div>
            @endif
        </div>
    </div>
@endsection
