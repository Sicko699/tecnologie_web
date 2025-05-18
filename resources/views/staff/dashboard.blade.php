@extends('layouts.app')
@section('title', 'Dashboard Staff')
@section('content')
    <h2>Dashboard Staff</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h4 class="card-title">Appuntamenti Assegnati</h4>
                    <a href="{{ route('staff.appuntamenti.index') }}" class="btn btn-primary">Visualizza Appuntamenti</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h4 class="card-title">Gestione Prestazioni</h4>
                    <a href="{{ route('staff.prestazioni.index') }}" class="btn btn-primary">Visualizza Prestazioni</a>
                </div>
            </div>
        </div>
    </div>
@endsection
