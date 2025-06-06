@extends('layouts.app')
@section('title', 'Trattamenti')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center"><i class="bi bi-heart-pulse-fill"></i> Trattamenti Disponibili</h2>

        @if($trattamenti->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Nessun trattamento disponibile al momento.
            </div>
        @else
            <div class="row g-4">
                @foreach($trattamenti as $prestazione)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 hover-shadow" onclick="window.location='{{ route('prestazione.show', ['id' => $prestazione->id_prestazione]) }}'" style="cursor: pointer;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $prestazione->nome }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($prestazione->descrizione, 100) }}</p>

                                @if($prestazione->medico)
                                    <hr>
                                    <p class="mb-0"><i class="bi bi-person-vcard"></i> Medico: <strong>{{ $prestazione->medico->nome }} {{ $prestazione->medico->cognome }}</strong></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
