@extends('layouts.app')
@section('title', 'Prestazioni Gestite')
@section('content')
    <h3>Prestazioni di competenza</h3>
    <a href="{{ route('staff.prestazioni.create') }}" class="btn btn-success mb-3">Aggiungi Prestazione</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Dipartimento</th>
            <th>Descrizione</th>
            <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        @foreach($prestazioni as $prestazione)
            <tr>
                <td>{{ $prestazione->nome }}</td>
                <td>{{ $prestazione->dipartimento->nome }}</td>
                <td>{{ $prestazione->descrizione }}</td>
                <td>
                    <a href="{{ route('staff.prestazioni.edit', $prestazione->id_prestazione) }}" class="btn btn-warning btn-sm">Modifica</a>
                    <form action="{{ route('staff.prestazioni.destroy', $prestazione->id_prestazione) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Confermi eliminazione?')">Elimina</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
