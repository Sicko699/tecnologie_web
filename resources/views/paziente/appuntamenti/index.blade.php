@extends('layouts.app')
@section('title', 'I tuoi appuntamenti')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4 text-center">I tuoi appuntamenti</h2>
        @if($appuntamenti->count())
            <div class="table-responsive">
                <table class="table table-borderless align-middle bg-white shadow-sm" style="border-radius:14px;">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Ora</th>
                        <th>Prestazione</th>
                        <th>Stato</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appuntamenti as $app)
                        <tr>
                            <td>{{ $app->data }}</td>
                            <td>{{ $app->ora }}</td>
                            <td>{{ $app->richiesta->prestazione->nome ?? '-' }}</td>
                            <td>
                            <span class="badge rounded-pill {{ $app->stato == 'confermato' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($app->stato) }}
                            </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-5">
                <p class="mb-0">Nessun appuntamento trovato.</p>
            </div>
        @endif
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('paziente.dashboard') }}" class="btn btn-link text-muted" style="text-decoration:none;">Torna alla dashboard</a>
        </div>
    </div>
    <style>
        .table { border-radius: 14px; overflow: hidden; }
        .badge { font-size: 1em; }
        .btn-link { color: #2b79c9; text-decoration: none; }
        .btn-link:hover { color: #185f9e; text-decoration: underline; }
    </style>
@endsection
