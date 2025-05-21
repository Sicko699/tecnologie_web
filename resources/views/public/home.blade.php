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
                                    <h3 class="mb-0">{{ $medicoInEvidenza->name }}</h3>
                                    <span class="position">{{ $medicoInEvidenza->ruolo ?? 'Medico' }}</span>
                                </div>
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

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container-fluid px-md-0">
            <div class="row no-gutters">
                <!-- Servizi Dentali -->
                <div class="col-md-3 d-flex align-items-stretch">
                    <div class="consultation w-100 text-center px-4 px-md-5">
                        <h3 class="mb-4">Servizi Dentali</h3>
                        <p>
                            Dallo sbiancamento professionale alle protesi su misura, offriamo un’ampia gamma di prestazioni per mantenere il tuo sorriso sano e brillante.
                        </p>
                        <a href="{{ route('department.index') }}" class="btn-custom">Scopri i servizi</a>
                    </div>
                </div>
                <!-- Consulenza Gratuita -->
                <div class="col-md-6 d-flex align-items-stretch">
                    <div class="consultation consul w-100 px-4 px-md-5">
                        <div class="text-center">
                            <h3 class="mb-4">Consulenza Gratuita</h3>
                        </div>

                        {{-- Feedback visivo --}}
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('richiesta.pubblica.store') }}" method="POST" class="appointment-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" name="cognome" class="form-control" placeholder="Cognome" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <div class="form-field">
                                            <div class="select-wrap">
                                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                                <select name="reparto" class="form-control" required>
                                                    <option style="color: black;" value="">Seleziona reparto</option>
                                                    @foreach($dipartimenti as $dipartimento)
                                                        <option style="color: black;" value="{{ $dipartimento->nome }}">{{ $dipartimento->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <div class="input-wrap">
                                            <div class="icon"><span class="ion-md-calendar"></span></div>
                                            <input type="text" name="data" class="form-control appointment_date" placeholder="Data" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <div class="input-wrap">
                                            <div class="icon"><span class="ion-ios-clock"></span></div>
                                            <input type="text" name="ora" class="form-control appointment_time" placeholder="Orario" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="form-group">
                                        <input type="submit" value="Prenota" class="btn btn-secondary py-2 px-4">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Trova un Dentista -->
                <div class="col-md-3 d-flex align-items-stretch">
                    <div class="consultation w-100 text-center px-4 px-md-5">
                        <h3 class="mb-4">Il nostro team</h3>
                        <p>
                            Professionisti qualificati e sempre aggiornati per offrirti le migliori cure in un ambiente accogliente.
                        </p>
                        <a href="{{ route('doctor.index') }}" class="btn-custom">Scopri il team</a>
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
            <div class="row">
                @foreach($dottori as $dentista)
                    <div class="col-md-3 d-flex services align-self-stretch p-4">
                        <div class="media block-6 d-block text-center">
                            <div class="icon d-flex justify-content-center align-items-center">
                                <span class="{{ $dentista->icona ?? 'flaticon-drilling' }}"></span>
                            </div>
                            <div class="media-body p-2 mt-3">
                                <h3 class="heading">{{ $dentista->nome }}</h3>
                                <p>{{ $dentista->membroStaff->descrizione ?? 'Nessuna descrizione disponibile' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
