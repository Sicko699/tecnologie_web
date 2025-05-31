@extends('layouts.app')
@section('title', 'Agenda Giornaliera')

@section('content')
    <div class="container mt-4">
        <h1>Agenda Giornaliera</h1>
        <form action="{{ route('staff.agenda.giornaliera') }}" method="GET">
            <div class="form-group">
                <label for="id_prestazione">Prestazione</label>
                <select name="id_prestazione" class="form-control" required>
                    @foreach($prestazioni as $p)
                        <option value="{{ $p->id }}">{{ $p->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="giorno">Giorno</label>
                <input type="date" name="giorno" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Visualizza Agenda</button>
        </form>
    </div>
@endsection
