<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand" href="{{ route('home') }}">Smile</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav m-auto">
                <li class="nav-item{{ Request::routeIs('home') ? ' active' : '' }}"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item{{ Request::routeIs('doctor.*') ? ' active' : '' }}"><a href="{{ route('doctor.index') }}" class="nav-link">Dottori</a></li>
                <li class="nav-item{{ Request::routeIs('department.*') ? ' active' : '' }}"><a href="{{ route('department.index') }}" class="nav-link">Trattamenti</a></li>
                <li class="nav-item{{ Request::routeIs('contact') ? ' active' : '' }}"><a href="{{ route('contact') }}" class="nav-link">Contatti</a></li>
                @guest
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Registrati</a></li>
                @else
                    @role('admin')
                    <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a></li>
                    @endrole
                    @role('staff')
                    <li class="nav-item"><a href="{{ route('staff.dashboard') }}" class="nav-link">Staff</a></li>
                    @endrole
                    @role('paziente')
                    <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link">Area Utente</a></li>
                    @endrole
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" style="display: inline; padding: 0; margin: 0; color: inherit;">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
