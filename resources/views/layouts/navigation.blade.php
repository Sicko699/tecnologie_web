{{-- resources/views/layouts/navbar.blade.php --}}
<div class="w-100 py-1 bg-light border-bottom shadow-sm" style="font-size:0.95rem; letter-spacing: 0.01em;">
    <div class="container d-flex justify-content-center align-items-center gap-2" style="min-height:30px;">
        <i class="bi bi-file-earmark-pdf text-danger me-1" style="font-size:1rem;"></i>
        <a href="{{ asset('documentazione.pdf') }}" target="_blank" class="text-decoration-underline fw-bold text-dark" style="font-size:0.98em;">
            Documentazione del sito
        </a>
    </div>
</div>

<div class="py-md-5 py-4 border-bottom">
    <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
            <div class="col-md-4 order-md-2 mb-2 mb-md-0 align-items-center text-center">
                <a class="navbar-brand" href="{{ route('home') }}">Smile<span>Clinica Dentistica</span></a>
            </div>
            <div class="col-md-4 order-md-1 d-flex topper mb-md-0 mb-2 align-items-center text-md-right">
                <div class="icon d-flex justify-content-center align-items-center order-md-last">
                    <span class="icon-map"></span>
                </div>
                <div class="pr-md-4 pl-md-0 pl-3 text">
                    <p class="con"><span>Chiamata Gratuita </span> <span>+39 123 123 1234</span></p>
                    <p class="con">Via Guglielmo Oberdan 12, Ancona</p>
                </div>
            </div>
            <div class="col-md-4 order-md-3 d-flex topper mb-md-0 align-items-center">
                <div class="icon d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                <div class="text pl-3 pl-md-3">
                    <p class="hr"><span>Orari</span></p>
                    <p class="time"><span>Lun - Sab:</span> <span>8:00 - 20:00</span> Dom: Chiuso</p>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container d-flex align-items-center">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav m-auto align-items-center">
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link pl-0">Home</a>
                </li>
                <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}" class="nav-link">Chi Siamo</a>
                </li>
                <li class="nav-item {{ request()->routeIs('doctor.index') ? 'active' : '' }}">
                    <a href="{{ route('doctor.index') }}" class="nav-link">Dottori</a>
                </li>
                <li class="nav-item {{ request()->routeIs('department.index') ? 'active' : '' }}">
                    <a href="{{ route('department.index') }}" class="nav-link">Trattamenti</a>
                </li>
                <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" class="nav-link">Contatti</a>
                </li>

                {{-- Autenticazione --}}
                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name ?? Auth::user()->email }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">Profilo</a>
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Esci
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="guestDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="guestDropdown">
                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                            <a class="dropdown-item" href="{{ route('register') }}">Registrati</a>
                        </div>
                    </li>
                @endauth

                {{-- Form di ricerca --}}
                <li class="nav-item">
                    <form class="d-flex ms-3" method="GET" action="{{ route('ricerca.prestazioni') }}">
                        <input class="form-control form-control-sm me-2" type="search" name="q"
                               placeholder="Effettua una ricerca" aria-label="Cerca"
                               value="{{ request('q') }}">
                        <button class="btn btn-outline-info btn-sm rounded-pill px-3" type="submit">
                            Cerca
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
