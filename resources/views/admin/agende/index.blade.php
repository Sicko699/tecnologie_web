@extends('layouts.app')

@section('title', 'Lista Slot Agenda')

@section('content')
    <div class="container mt-4">
        <h1>Lista Slot Agenda</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Dipartimento</th>
                <th>Prestazione</th>
                <th>Giorno</th>
                <th>Orario Inizio</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($agende as $agenda)
                <tr>
                    <td>{{ $agenda->id_agenda }}</td>
                    <td>{{ $agenda->dipartimento->nome ?? '-' }}</td>
                    <td>{{ $agenda->prestazione->nome ?? '-' }}</td>
                    <td>
                        @php
                            $giorni = ['Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato', 'Domenica'];
                        @endphp
                        {{ $giorni[$agenda->giorno_settimana] ?? '-' }}
                    </td>
                    <td>{{ $agenda->orario_inizio }}</td>
                    <td>
                    <td class="d-flex gap-1">
                        <!-- Link Modifica -->
                        <a href="{{ route('admin.agende.edit', ['agende' => $agenda->id_agenda]) }}" class="btn btn-sm btn-primary">
                            Modifica
                        </a>

                        <!-- Link Giornaliera -->
                        <a href="{{ route('admin.agende.giornaliera', ['id' => $agenda->id_agenda, 'data' => now()->toDateString()]) }}" class="btn btn-sm btn-info">
                            Giornaliera
                        </a>

                        <!-- Form per eliminare -->
                        <form action="{{ route('admin.agende.destroy', ['agende' => $agenda->id_agenda]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Sei sicuro di voler eliminare?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Elimina</button>
                        </form>
                    </td>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.agende.create') }}" class="btn btn-success mt-3">Nuovo Slot Agenda</a>
    </div>
@endsection
