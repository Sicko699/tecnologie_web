@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-4">mannaggia la madonna</h1>
        <p class="lead">Il tuo sorriso, la nostra missione!</p>
        <a href="{{ route('register') }}" class="btn btn-success btn-lg mt-3">Prenota una visita</a>
    </div>
@endsection
