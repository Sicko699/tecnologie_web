@extends('layouts.app')
@section('title', 'I nostri Dottori')
@section('content')
    <section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
        <div class="container">
            <div class="row d-flex align-items-stretch no-gutters">
                <!-- Form -->
                <div class="col-md-6 p-4 p-md-5 order-md-last bg-light">
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Il tuo nome">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="La tua email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Oggetto">
                        </div>
                        <div class="form-group">
                            <textarea cols="30" rows="7" class="form-control" placeholder="Messaggio"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Invia messaggio" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <!-- Mappa Embed -->
                <div class="col-md-6 d-flex align-items-stretch">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.417091779479!2d13.513812415554915!3d43.606215879125836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132da3c58ebfaab7%3A0xe3032a526e3e3b05!2sVia%20Guglielmo%20Oberdan%2C%2012%2C%2060118%20Ancona%20AN!5e0!3m2!1sit!2sit!4v1688400000000"
                        width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Informazioni di contatto -->
    <section class="ftco-section contact-section">
        <div class="container">
            <div class="row d-flex mb-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h4">Informazioni di contatto</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-md-3 d-flex">
                    <div class="bg-light d-flex align-self-stretch box p-4">
                        <p><span>Indirizzo:</span> Via Guglielmo Oberdan 12, 60118 Ancona (AN)</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="bg-light d-flex align-self-stretch box p-4">
                        <p><span>Telefono:</span> <a href="tel:+390612345678">+39 06 1234 5678</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="bg-light d-flex align-self-stretch box p-4">
                        <p><span>Email:</span> <a href="mailto:info@studiosmile.it">info@studiosmile.it</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="bg-light d-flex align-self-stretch box p-4">
                        <p><span>Sito web:</span> <a href="#">studiosmile.it</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
