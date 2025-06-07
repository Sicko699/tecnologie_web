@extends('layouts.app')

@section('title', 'I nostri Dottori')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center">
            <i class="bi bi-person-badge"></i> I Nostri Dottori
        </h2>

        @if($dottori->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Nessun dottore disponibile al momento.
            </div>
        @else
            <div class="row g-4">
                @foreach($dottori as $index => $dottore)
                    @php
                        // img fallback smart: doc-2, doc-3, ..., doc-7
                        $img = $dottore->immagine ?? 'doc-' . (($index % 6) + 2) . '.jpg';
                    @endphp
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                        <div class="dentist-card w-100">
                            <img class="dentist-photo"
                                 src="{{ asset('images/' . $img) }}"
                                 alt="Foto {{ $dottore->nome }} {{ $dottore->cognome }}">
                            <div class="dentist-name">{{ $dottore->nome }} {{ $dottore->cognome }}</div>
                            <div class="dentist-role">
                                {{ $dottore->specializzazione ?? $dottore->ruolo ?? 'Dentista' }}
                            </div>
                            <div class="dentist-desc">
                                {{ $dottore->membroStaff->descrizione ?? 'Nessuna descrizione disponibile.' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <style>
            .dentist-card {
                background: #fff;
                border-radius: 1.5rem;
                box-shadow: 0 2px 16px 0 rgba(50,50,93,.07), 0 0.5px 1.5px 0 rgba(0,0,0,.03);
                padding: 2rem 1.2rem 1.5rem 1.2rem;
                text-align: center;
                transition: transform .16s cubic-bezier(.4,2.3,.3,1), box-shadow .16s;
                cursor: pointer;
                border: none;
                min-height: 330px;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                position: relative;
            }
            .dentist-card:hover {
                transform: translateY(-6px) scale(1.025);
                box-shadow: 0 8px 32px 0 rgba(60,60,93,.13), 0 1.5px 6px 0 rgba(0,0,0,.09);
            }
            .dentist-photo {
                width: 96px;
                height: 96px;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 2px 8px rgba(50,50,93,0.09);
                margin-bottom: 1.2rem;
                border: 4px solid #f5f6fa;
                background: #f5f6fa;
            }
            .dentist-name {
                font-size: 1.2rem;
                font-weight: 700;
                margin-bottom: 0.15rem;
                letter-spacing: 0.01em;
                color: #262a35;
                line-height: 1.2;
            }
            .dentist-role {
                font-size: 0.97rem;
                color: #888ea2;
                font-weight: 500;
                margin-bottom: 0.7rem;
                letter-spacing: 0.02em;
            }
            .dentist-desc {
                font-size: 0.95rem;
                color: #5a6072;
                margin-bottom: 0;
                line-height: 1.45;
                min-height: 3.5em;
                font-weight: 400;
            }
            @media (max-width: 768px) {
                .dentist-card {
                    min-height: 290px;
                    padding: 1.2rem 0.5rem;
                }
            }
        </style>
    </div>
@endsection
