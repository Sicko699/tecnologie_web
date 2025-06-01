@extends('layouts.app')
@section('title', 'Agenda Giornaliera')

@section('content')
    <div class="container mt-4">
        <h2>Agenda Giornaliera</h2>
        <p><strong>Data:</strong> {{ $data }}</p>
        <p><strong>Prestazione:</strong> {{ $agenda->prestazione?->nome ?? 'N/D' }}</p>
        <p><strong>Dipartimento:</strong> {{ $agenda->dipartimento?->nome ?? 'N/D' }}</p>
        <p><strong>Giorno della settimana:</strong>
            @php
                $giorni = ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'];
            @endphp
            {{ $giorni[$agenda->giorno_settimana] ?? 'N/D' }}
        </p>
        <p><strong>Slot:</strong> {{ $agenda->slot_orario }}</p>
        <p><strong>Max appuntamenti:</strong> {{ $agenda->max_appuntamenti }}</p>

        <form method="GET" class="mt-3">
            <label for="data">Cambia data:</label>
            <input type="date" name="data" value="{{ $data }}" onchange="this.form.submit()">
        </form>

        <hr>

        <h4>Appuntamenti per questo slot</h4>

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>#</th>
                <th>Slot Orario</th>
                <th>Utente</th>
            </tr>
            </thead>
            <tbody>
            @foreach($slotInfo as $i => $slot)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $slot['slot_orario'] }}</td>
                    <td>{{ $slot['utente'] ?? '—' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary mt-3">Torna alla lista</a>
    </div>
@endsection
