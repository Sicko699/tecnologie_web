@extends('layouts.app')
@section('title', 'Home')
@section('content')

    <section class="home-slider owl-carousel">
        <!-- Prima card -->
        <div class="slider-item" style="background-image:url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-end"
                     data-scrollax-parent="true">
                    <div class="col-md-6 text ftco-animate">
                        <h1 class="mb-4">Aiutiamo il tuo <span>benessere ogni giorno</span></h1>
                        <h3 class="subheading">Ogni giorno portiamo speranza e un sorriso ai pazienti che assistiamo
                        </h3>
                        <p><a href="{{ route('department.index') }}" class="btn btn-secondary px-4 py-3 mt-3">I nostri lavori</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seconda card -->
        <div class="slider-item" style="background-image:url(images/bg_2.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-end"
                     data-scrollax-parent="true">
                    <div class="col-md-6 text ftco-animate">
                        <h1 class="mb-4">Un sorriso lascia <br>un'impressione duratura</h1>
                        <h3 class="subheading">La tua salute è la nostra massima priorità, con cure mediche complete e accessibili.
                        </h3>
                        <p><a href="{{ route('department.index') }}" class="btn btn-secondary px-4 py-3 mt-3">I nostri lavori</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-5 p-md-5 img img-2 mt-5 mt-md-0" style="background-image: url(images/about.jpg);">
                </div>
                <div class="col-md-7 wrap-about py-4 py-md-5 ftco-animate">
                    <div class="heading-section mb-5">
                        <div class="pl-md-5 ml-md-5 pt-md-5">
                            <span class="subheading mb-2">Benvenuto da Smile</span>
                            <h2 class="mb-2" style="font-size: 32px;">
                                Specialità odontoiatrica dedicata alla prevenzione e al trattamento delle patologie orali dei pazienti presso uno studio dentistico.
                            </h2>
                        </div>
                    </div>
                    <div class="pl-md-5 ml-md-5 mb-5">
                        <p>
                            Presso il nostro studio Smile, il benessere e la sicurezza dei pazienti sono al centro di ogni intervento: grazie a tecnologie digitali avanzate e rigorosi protocolli di igiene, offriamo una vasta gamma di prestazioni – dalla semplice igiene orale alle terapie implantari – sempre in un ambiente confortevole e accogliente.
                        </p>
                        <p>
                            Il nostro team di odontoiatri e igienisti dentali, costantemente aggiornato sulle più recenti innovazioni, adotta un approccio personalizzato basato sulla prevenzione e sull’attenzione estetica: il nostro obiettivo è restituirti un sorriso sano e armonioso, preservando la tua salute orale nel tempo.
                        </p>
                        @if($medicoInEvidenza)
                            <div class="founder d-flex align-items-center mt-5">
                                <div class="img"
                                     style="background-image: url('{{ asset('images/' . ($medicoInEvidenza->immagine ?? 'doc-1.jpg')) }}');
                    width: 100px; height: 100px; border-radius: 50%; background-size: cover;">
                                </div>
                                <div class="text pl-3">
                                    <h3 class="mb-0">{{ $medicoInEvidenza->nome }} {{ $medicoInEvidenza->cognome }}</h3>
                                    <span class="position">{{ $medicoInEvidenza->specializzazione ?? 'Medico' }}</span>
                                </div>
                        @else
                            <p class="text-danger mt-3">⚠️ Nessun medico disponibile al momento.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="ftco-section ftco-services">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section">
                    <span class="subheading">Servizi</span>
                    <h2 class="mb-4">I nostri servizi</h2>
                    <p>
                        Presso lo studio Smile offriamo soluzioni all’avanguardia per la tua salute orale.
                    </p>
                </div>
            </div>
            <div class="row">
                @foreach($trattamenti as $trattamento)
                    <div class="col-md-3 d-flex services align-self-stretch p-4">
                        <div class="media block-6 d-block text-center">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="{{ $trattamento->icona ?? 'flaticon-drilling' }}"></span>
                            </div>
                            <div class="media-body p-2 mt-3">
                                <h3 class="heading">{{ $trattamento->nome }}</h3>
                                <p>{{ $trattamento->descrizione }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ftco-section intro" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-4">Al tuo sorriso pensiamo noi, ogni giorno manteniamo le nostre promesse.</h3>
                    <p>
                        Presso lo studio Smile mettiamo la tua salute orale al primo posto: un ambiente confortevole, professionisti dedicati e tecnologie all’avanguardia per offrirti cure precise e durature.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <span class="subheading">Dentisti</span>
                    <h2 class="mb-4">Il nostro team di dentisti qualificati</h2>
                    <p>
                        I professionisti dello studio Smile uniscono competenza e passione per offrirti cure personalizzate in un ambiente accogliente e all’avanguardia.
                    </p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($dottori as $index => $dentista)
                    @php
                        // img fallback smart: doc-2, doc-3, ..., doc-7
                        $img = $dentista->immagine ?? 'doc-' . (($index % 6) + 2) . '.jpg';
                    @endphp
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                        <div class="dentist-card w-100">
                            <img class="dentist-photo"
                                 src="{{ asset('images/' . $img) }}"
                                 alt="Foto {{ $dentista->nome }} {{ $dentista->cognome }}">
                            <div class="dentist-name">{{ $dentista->nome }} {{ $dentista->cognome }}</div>
                            <div class="dentist-role">
                                {{ $dentista->ruolo ?? 'Dentista' }}
                            </div>
                            <div class="dentist-desc">
                                {{ $dentista->membroStaff->descrizione ?? 'Nessuna descrizione disponibile.' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


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
    </section>

@endsection
