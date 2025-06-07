{{-- resources/views/layouts/footer.blade.php --}}
<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row mb-5">
            <!-- About -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-5">
                    <h2 class="ftco-heading-2 logo">Studio Dentistico Smile</h2>
                    <p>
                        Mettiamo il tuo sorriso al centro: professionalità, tecnologie all’avanguardia e un ambiente
                        accogliente per garantirti cure di qualità.
                    </p>
                </div>
                <div class="ftco-footer-widget mb-5">
                    <h2 class="ftco-heading-2">Contatti</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li>
                                <span class="icon icon-map-marker"></span>
                                <span class="text">Via Guglielmo Oberdan 12, Ancona</span>
                            </li>
                            <li>
                                <a href="tel:+390612345678">
                                    <span class="icon icon-phone"></span>
                                    <span class="text">+39 06 1234 5678</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:info@studiosmile.it">
                                    <span class="icon icon-envelope"></span>
                                    <span class="text">info@studiosmile.it</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Links -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-5 ml-md-4">
                    <h2 class="ftco-heading-2">Link Utili</h2>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
                        <li><a href="{{ route('about') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Chi Siamo</a></li>
                        <li><a href="{{ route('department.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Trattamenti</a></li>
                        <li><a href="{{ route('doctor.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Dottori</a></li>
                        <li><a href="{{ route('contact') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Contatti</a></li>

                    </ul>
                </div>
                <div class="ftco-footer-widget mb-5 ml-md-4">
                    <h2 class="ftco-heading-2">Servizi</h2>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('department.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Igiene Orale</a></li>
                        <li><a href="{{ route('department.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Ortodonzia</a></li>
                        <li><a href="{{ route('department.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Implantologia</a></li>
                        <li><a href="{{ route('department.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Estetica Dentale</a></li>
                        <li><a href="{{ route('department.index') }}"><span class="ion-ios-arrow-round-forward mr-2"></span>Parodontologia</a></li>
                    </ul>
                </div>
            </div>
            <!-- Opening Hours & Newsletter -->
            <div class="col-md">
                <div class="ftco-footer-widget mb-5">
                    <h2 class="ftco-heading-2">Orari di Apertura</h2>
                    <h3 class="open-hours pl-4">
                        <span class="ion-ios-time mr-3"></span>Lun–Ven: 9:00–19:00<br>
                        Sabato: 9:00–13:00<br>
                        Domenica: chiuso
                    </h3>
                </div>
                <div class="ftco-footer-widget mb-5 footer-map-large "style="height: 250px; min-height: 200px; width: 320px; min-width: 270px">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.417091779479!2d13.513812415554915!3d43.606215879125836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132da3c58ebfaab7%3A0xe3032a526e3e3b05!2sVia%20Guglielmo%20Oberdan%2C%2012%2C%2060118%20Ancona%20AN!5e0!3m2!1sit!2sit!4v1688400000000"
                        width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p>
                    &copy; <script>document.write(new Date().getFullYear());</script> Studio Dentistico Smile. Tutti i diritti riservati.
                </p>
            </div>
        </div>
    </div>
</footer>
