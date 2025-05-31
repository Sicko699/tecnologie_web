@extends('layouts.app')
@section('title', 'Statistiche')

@section('content')
    <div class="container mt-4">
        <h1>Statistiche Prestazioni</h1>
        <form method="GET" class="row g-3 mb-4">
            <div class="col-auto">
                <label>Dal:</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" />
            </div>
            <div class="col-auto">
                <label>Al:</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" />
            </div>
            <div class="col-auto">
                <label>Utente (opzionale):</label>
                <input type="number" name="utente_id" value="{{ request('utente_id') }}" class="form-control" placeholder="ID utente" />
            </div>
            <div class="col-auto d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtra</button>
            </div>
        </form>

        <h5>Numero Prestazioni per Tipo</h5>
        <ul>
            @foreach($prestazioniCount as $item)
                <li>
                    {{ $item->prestazione->nome ?? 'N/A' }}: <strong>{{ $item->totale }}</strong>
                </li>
            @endforeach
        </ul>

        <h5>Numero Prestazioni per Dipartimento</h5>
        <ul>
            @foreach($dipartimentiCount as $item)
                <li>
                    {{ $item->dipartimento->nome ?? 'N/A' }}: <strong>{{ $item->totale }}</strong>
                </li>
            @endforeach
        </ul>

        @if($prestazioniUtente)
            <h5>Prestazioni erogate all'utente ID {{ request('utente_id') }}</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>ID Appuntamento</th>
                    <th>Prestazione</th>
                    <th>Dipartimento</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                @foreach($prestazioniUtente as $p)
                    <tr>
                        <td>{{ $p->id_prestazione}}</td>
                        <td>{{ $p->prestazione->nome ?? '-' }}</td>
                        <td>{{ $p->dipartimento->nome ?? '-' }}</td>
                        <td>{{ $p->data ?? '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
