@extends('layouts.app')
@section('title', 'Trattamenti')

@section('content')
    <h2 class="mb-4">Trattamenti disponibili</h2>
    <div class="row">
        @foreach($trattamenti as $prestazione)
            <div class="col-md-4 mb-4">
                <div class="card" onclick="window.location='{{ route('prestazione.show', ['id' => $prestazione->id_prestazione]) }}'">
                    <div class="card-body">
                        <h5 class="card-title">{{ $prestazione->nome }}</h5>
                        <p class="card-text">{{ Str::limit($prestazione->descrizione, 100) }}</p>
                        @if($prestazione->medico)
                            <p class="text-muted">Medico: {{ $prestazione->medico->nome }} {{ $prestazione->medico->cognome }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
