@extends('layouts.app')
@section('title', 'I nostri Contatti')
@section('content')
    <section class="ftco-section contact-section">
        <div class="container">
            <div class="row g-4 d-flex no-gutters">

                <div class="col-md-6 d-flex align-items-stretch mb-4 mb-md-0 pr-md-3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.417091779479!2d13.513812415554915!3d43.606215879125836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132da3c58ebfaab7%3A0xe3032a526e3e3b05!2sVia%20Guglielmo%20Oberdan%2C%2012%2C%2060118%20Ancona%20AN!5e0!3m2!1sit!2sit!4v1688400000000"
                        width="100%" height="100%" frameborder="0" style="border:0; min-height: 350px;" allowfullscreen="" aria-hidden="false" tabindex="0">
                    </iframe>
                </div>

                <div class="col-md-6 d-flex flex-wrap align-items-start pl-md-3">
                    <div class="row w-100">
                        <div class="col-md-12 mb-4">
                            <h2 class="h4">Informazioni di contatto</h2>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light box p-4 h-100">
                                <p><strong>Indirizzo:</strong><br>Via Guglielmo Oberdan 12, 60118 Ancona (AN)</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light box p-4 h-100">
                                <p><strong>Telefono:</strong><br><a href="tel:+390612345678">+39 06 1234 5678</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light box p-4 h-100">
                                <p><strong>Email:</strong><br><a href="mailto:info@studiosmile.it">info@studiosmile.it</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light box p-4 h-100">
                                <p><strong>Sito web:</strong><br><a href="#">studiosmile.it</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
