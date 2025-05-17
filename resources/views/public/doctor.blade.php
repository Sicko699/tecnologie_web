@extends('layouts.app')
@section('title', 'I nostri Dottori')
@section('content')
    <h2>I nostri dottori</h2>
    <div class="row">
        @foreach($dottori as $dottore)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $dottore->foto_url }}" class="card-img-top" alt="Foto Dottore">
                    <div class="card-body">
                        <h5 class="card-title">{{ $dottore->nome }} {{ $dottore->cognome }}</h5>
                        <p class="card-text">{{ $dottore->specializzazione }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
