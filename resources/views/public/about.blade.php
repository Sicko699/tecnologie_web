@extends('layouts.app')
@section('title', 'Chi siamo')
@section('content')

    <!-- Hero Section -->
    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('images/bg_1.jpg') }}');"
             data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-2 bread">Chi Siamo</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-5 p-md-5 img img-2 mt-5 mt-md-0"
                     style="background-image: url('{{ asset('images/about.jpg') }}');">
                </div>
                <div class="col-md-7 wrap-about py-4 py-md-5 ftco-animate">
                    <div class="heading-section mb-5">
                        <div class="pl-md-5 ml-md-5 pt-md-5">
                            <span class="subheading mb-2">Benvenuto da Smile</span>
                            <h2 class="mb-2" style="font-size: 32px;">
                                Specialità medica dedicata alla cura dei pazienti gravemente malati ricoverati in ospedale
                            </h2>
                        </div>
                    </div>
                    <div class="pl-md-5 ml-md-5 mb-5">
                        <p>
                            Il nostro Studio si avvale di un Team qualificato e appassionato, composto da Medici,
                            Dentisti, Igieniste, Odontotecnici e preziose Collaboratrici che uniscono competenze
                            professionali di alto livello a una grande attenzione al lato umano nel rapporto con il paziente.
                        </p>
                        <p>
                            L’eccellenza dei nostri professionisti è supportata da una continua formazione e dall’utilizzo
                            di materiali di qualità superiore, affiancati da tecnologie innovative. Disponiamo di strumenti
                            all’avanguardia che ci permettono di offrire trattamenti efficaci, sicuri e meno invasivi,
                            pensati per soddisfare al meglio le esigenze dei pazienti.
                        </p>

                        @if($medico)
                            <div class="founder d-flex align-items-center mt-5">
                                <div class="img"
                                     style="background-image: url('{{ asset('images/' . ($medico->immagine ?? 'doc-1.jpg')) }}'); width:100px; height:100px; border-radius: 50%; background-size: cover;">
                                </div>
                                <div class="text pl-3">
                                    <h3 class="mb-0">{{ $medico->name }}</h3>
                                    <span class="position">{{ $medico->ruolo ?? 'Medico' }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-danger mt-4">⚠️ Nessun medico disponibile da visualizzare.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
