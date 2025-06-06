@extends('layouts.app')

@section('title', 'I nostri Dottori')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center"><i class="bi bi-person-badge"></i> I Nostri Dottori</h2>

        @if($dottori->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Nessun dottore disponibile al momento.
            </div>
        @else
            <div class="row g-4">
                @foreach($dottori as $dottore)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ $dottore->foto_url }}" class="card-img-top" alt="Foto di {{ $dottore->nome }} {{ $dottore->cognome }}" style="object-fit: cover; height: 300px;">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $dottore->nome }} {{ $dottore->cognome }}</h5>
                                <p class="text-muted mb-0"><i class="bi bi-mortarboard"></i> {{ $dottore->specializzazione }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
