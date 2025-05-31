@extends('layouts.app')
@section('title', 'Utenti Staff/Admin')

@section('content')
    <div class="container mt-4">
        <h1>Utenti Staff/Admin</h1>
        <a href="{{ route('admin.utenti.create') }}" class="btn btn-success mb-3">Aggiungi Utente</a>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Codice Fiscale</th>
                <th>Ruolo</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($utenti as $u)
                <tr>
                    <td>{{ $u->codice_fiscale }}</td>
                    <td>{{ $u->nome }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ ucfirst($u->ruolo) }}</td>
                    <td>
                        <a href="{{ route('admin.utenti.edit', ['utenti' => $u->codice_fiscale]) }}" class="btn btn-primary btn-sm">Modifica</a>
                        <form action="{{ route('admin.utenti.destroy', ['utenti' => $u->codice_fiscale]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confermi eliminazione?')">
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
