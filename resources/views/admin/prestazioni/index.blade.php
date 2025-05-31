@extends('layouts.app')
@section('title', 'Prestazioni')

@section('content')
    <div class="container mt-4">
        <h1>Prestazioni</h1>
        <a href="{{ route('admin.prestazioni.create') }}" class="btn btn-success mb-3">Aggiungi Prestazione</a>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Dipartimento</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prestazioni as $p)
                <tr>
                    <td>{{ $p->id_prestazione }}</td>
                    <td>{{ $p->nome }}</td>
                    <td>{{ $p->dipartimento->nome ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.prestazioni.edit', ['prestazioni' => $p->id_prestazione]) }}" class="btn btn-primary btn-sm">Modifica</a>
                        <form action="{{ route('admin.prestazioni.destroy', ['prestazioni' => $p->id_prestazione]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confermi eliminazione?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
