<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm" id="ftco-navbar">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Smile</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav m-auto">
                <li class="nav-item{{ Request::routeIs('home') ? ' active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item{{ Request::routeIs('doctor.*') ? ' active' : '' }}">
                    <a href="{{ route('doctor.index') }}" class="nav-link">Dottori</a>
                </li>
                <li class="nav-item{{ Request::routeIs('department.*') ? ' active' : '' }}">
                    <a href="{{ route('department.index') }}" class="nav-link">Trattamenti</a>
                </li>
                <li class="nav-item{{ Request::routeIs('contact') ? ' active' : '' }}">
                    <a href="{{ route('contact') }}" class="nav-link">Contatti</a>
                </li>
            </ul>
            <!-- Ricerca moderna -->
            <form class="d-none d-lg-flex position-relative me-3" action="{{ route('search') }}" method="GET" style="min-width:210px;">
                <input class="form-control search-input" type="search" placeholder="Cerca..." aria-label="Search" name="q" autocomplete="off">
                <button class="btn search-btn" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <!-- Icona profilo -->
            @guest
                <a href="{{ route('login') }}" class="btn btn-profile ms-2" title="Accedi">
                    <i class="fa-regular fa-user fa-lg"></i>
                </a>
            @else
                <div class="dropdown ms-2">
                    <a class="btn btn-profile dropdown-toggle" href="#" role="button" id="dropdownProfile" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-regular fa-user fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownProfile">
                        <a class="dropdown-item" href="@role('paziente'){{ route('user.dashboard') }}@else{{ route('home') }}@endrole">
                            Profilo
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>

<style>
    /* Evidenzia la tab corrente e hover */
    .navbar-nav .nav-link {
        color: #f7f7f7 !important;
        padding: 0.75rem 1.1rem;
        transition: background 0.19s, color 0.19s;
        border-radius: 18px;
        font-weight: 500;
        letter-spacing: .03em;
        font-size: 1.05em;
    }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
        background: #243a55;
        color: #fff !important;
        text-decoration: none;
    }
    .navbar-nav .nav-item.active .nav-link,
    .navbar-nav .nav-link.active {
        background: #fff;
        color: #1c315a !important;
        font-weight: bold;
        box-shadow: 0 2px 8px 0 rgba(44,64,107,0.07);
    }
    .btn-profile {
        background: #25292e;
        color: #a7b3c8;
        border-radius: 50%;
        padding: .48em .62em;
        transition: background 0.18s, color 0.18s;
        border: none;
        outline: none;
    }
    .btn-profile:hover, .btn-profile:focus {
        background: #1c315a;
        color: #fff;
        text-decoration: none;
    }
    .dropdown-menu {
        min-width: 10rem;
        border-radius: 16px;
        font-size: 1.05em;
    }
    .search-input {
        border-radius: 18px 0 0 18px;
        border-right: none;
        background: #f4f7fc;
        padding-left: 1em;
        font-size: 1em;
        border: 1px solid #e3e7ef;
        height: 40px;
        outline: none;
        transition: box-shadow 0.15s;
    }
    .search-input:focus {
        box-shadow: 0 2px 10px 0 rgba(44,64,107,0.08);
    }
    .search-btn {
        border-radius: 0 18px 18px 0;
        border-left: none;
        background: #2b79c9;
        color: #fff;
        border: 1px solid #2b79c9;
        height: 40px;
        width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: -2px;
        transition: background 0.16s;
    }
    .search-btn:hover, .search-btn:focus {
        background: #185f9e;
        color: #fff;
    }
    @media (max-width: 991px) {
        .navbar-nav { text-align: center; }
        .search-input, .search-btn { border-radius: 18px !important; width: 100% !important; }
        .d-lg-flex { display: none !important; }
    }
</style>
