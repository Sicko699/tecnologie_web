{{-- resources/views/layouts/navbar.blade.php --}}
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
            <ul class="navbar-nav m-auto">
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
                <li class="nav-item {{ request()->routeIs('prezzi') ? 'active' : '' }}">
                    <a href="{{ route('prezzi') }}" class="nav-link">Prezzi</a>
                </li>
                <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" class="nav-link">Contatti</a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name ?? Auth::user()->email }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profilo</a>
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
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Registrati</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
