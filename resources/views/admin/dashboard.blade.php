@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
    <h2>Dashboard Amministratore</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Dipartimenti</h4>
                    <a href="{{ route('admin.dipartimenti.index') }}" class="btn btn-primary">Gestisci Dipartimenti</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Prestazioni</h4>
                    <a href="{{ route('admin.prestazioni.index') }}" class="btn btn-primary">Gestisci Prestazioni</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Utenti</h4>
                    <a href="{{ route('admin.utenti.index') }}" class="btn btn-primary">Gestisci Utenti</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Appuntamenti</h4>
                    <a href="{{ route('admin.appuntamenti.index') }}" class="btn btn-primary">Gestisci Appuntamenti</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">Statistiche</h4>
                    <a href="{{ route('admin.statistiche.index') }}" class="btn btn-info">Visualizza Statistiche</a>
                </div>
            </div>
        </div>
    </div>
@endsection
