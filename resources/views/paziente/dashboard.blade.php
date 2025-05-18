@extends('layouts.app')
@section('title', 'Area Utente')
@section('content')
    <h2>Benvenuto, {{ Auth::user()->nome }}</h2>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h4 class="card-title">Le tue prenotazioni</h4>
                    <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-primary">Gestisci Prenotazioni</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h4 class="card-title">I tuoi appuntamenti</h4>
                    <a href="{{ route('paziente.appuntamenti.index') }}" class="btn btn-primary">Visualizza Appuntamenti</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body text-center">
            <h4 class="card-title">Profilo Utente</h4>
            <a href="{{ route('paziente.profilo') }}" class="btn btn-secondary">Visualizza/Modifica Profilo</a>
        </div>
    </div>
@endsection
