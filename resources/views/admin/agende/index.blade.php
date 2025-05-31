@extends('layouts.app')
@section('title', 'Agenda Slot Orari')

@section('content')
    <div class="container mt-4">
        <h1>Slot Agenda</h1>
        <a href="{{ route('admin.agende.create') }}" class="btn btn-success mb-3">Aggiungi Slot</a>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Dipartimento</th>
                <th>Prestazione</th>
                <th>Giorno</th>
                <th>Orario</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($agende as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>{{ $a->dipartimento->nome ?? '-' }}</td>
                    <td>{{ $a->prestazione->nome ?? '-' }}</td>
                    <td>
                        @php $giorni = ['Lun','Mar','Mer','Gio','Ven','Sab','Dom']; @endphp
                        {{ $giorni[$a->giorno_settimana] ?? $a->giorno_settimana }}
                    </td>
                    <td>{{ $a->orario_inizio }}</td>
                    <td>
                        <a href="{{ route('admin.agende.edit', ['agende' => $a->id]) }}" class="btn btn-primary btn-sm">Modifica</a>
                        <form action="{{ route('admin.agende.destroy', ['agende' => $a->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confermi eliminazione?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
