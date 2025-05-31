@extends('layouts.app')
@section('title', 'Dipartimenti')

@section('content')
    <div class="container mt-4">
        <h1>Dipartimenti</h1>
        <a href="{{ route('admin.dipartimenti.create') }}" class="btn btn-success mb-3">Aggiungi Dipartimento</a>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dipartimenti as $d)
                <tr>
                    <td>{{ $d->id_dipartimento }}</td>
                    <td>{{ $d->nome }}</td>
                    <td>
                        <a href="{{ route('admin.dipartimenti.edit', ['dipartimenti' => $d->id_dipartimento]) }}" class="btn btn-primary btn-sm">Modifica</a>

                        <form action="{{ route('admin.dipartimenti.destroy', ['dipartimenti' => $d->id_dipartimento]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confermi eliminazione?')">
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
