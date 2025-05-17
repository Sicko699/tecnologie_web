@extends('layouts.app')
@section('title', 'Trattamenti')
@section('content')
    <h2>Trattamenti</h2>
    <div class="row">
        @foreach($trattamenti as $trattamento)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $trattamento->nome }}</h5>
                        <p class="card-text">{{ $trattamento->descrizione }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
