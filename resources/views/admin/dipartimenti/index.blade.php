@extends('layouts.app')
@section('title', 'Dipartimenti')
@section('content')
    <h3>Gestione Dipartimenti</h3>
    <a href="{{ route('admin.dipartimenti.create') }}" class="btn btn-success mb-3">Nuovo Dipartimento</a>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Azioni</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dipartimenti as $dip)
            <tr>
                <td>{{ $dip->nome }}</td>
                <td>{{ $dip->descrizione }}</td>
                <td>
                    <a href="{{ route('admin.dipartimenti.show', $dip->id_dipartimento) }}" class="btn btn-info btn-sm">Visualizza</a>
                    <a href="{{ route('admin.dipartimenti.edit', $dip->id_dipartimento) }}" class="btn btn-warning btn-sm">Modifica</a>
                    <form action="{{ route('admin.dipartimenti.destroy', $dip->id_dipartimento) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Confermi eliminazione?')">Elimina</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
