@extends('layouts.app')
@section('title', 'Dashboard Utente')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fas fa-user-circle me-2 text-primary"></i>
                Benvenuto, {{ Auth::user()->nome }}
            </h2>
            <!-- Campanella notifiche -->
            <button class="btn btn-link p-0 position-relative" style="font-size: 2rem;" data-bs-toggle="modal" data-bs-target="#notificheModal" id="notificheBtn">
                <i class="fas fa-bell"></i>
                @if(isset($notifiche) && count($notifiche->where('conferma_lettura', false)))
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificheBadge" style="font-size:.8em;">
                        {{ $notifiche->where('conferma_lettura', false)->count() }}
                    </span>
                @endif
            </button>
        </div>

        {{-- CARDS --}}
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 h-100 text-center p-4" style="background: #fafbfc;">
                    <i class="fas fa-calendar-plus fa-2x mb-2 text-success"></i>
                    <h5 class="mb-2 fw-semibold">Richieste</h5>
                    <a href="{{ route('paziente.prenotazioni.index') }}" class="btn btn-primary w-100 mt-2" style="border-radius:20px;">Gestisci Prenotazioni</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 h-100 text-center p-4" style="background: #fafbfc;">
                    <i class="fas fa-calendar-check fa-2x mb-2 text-primary"></i>
                    <h5 class="mb-2 fw-semibold">Appuntamenti</h5>
                    <a href="{{ route('paziente.appuntamenti.index') }}" class="btn btn-outline-primary w-100 mt-2" style="border-radius:20px;">Visualizza Appuntamenti</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 h-100 text-center p-4" style="background: #fafbfc;">
                    <i class="fas fa-user-cog fa-2x mb-2 text-secondary"></i>
                    <h5 class="mb-2 fw-semibold">Profilo</h5>
                    <a href="{{ route('paziente.profilo') }}" class="btn btn-outline-secondary w-100 mt-2" style="border-radius:20px;">Profilo Utente</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALE NOTIFICHE -->
    <div class="modal fade" id="notificheModal" tabindex="-1" aria-labelledby="notificheModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="notificheModalLabel">
                        <i class="fas fa-bell me-2 text-warning"></i>Notifiche
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body px-4">
                    @if(isset($notifiche) && count($notifiche))
                        <ul class="list-group list-group-flush mb-3" id="notificheList">
                            @foreach($notifiche as $notifica)
                                <li class="list-group-item d-flex align-items-center px-0" style="border:none;">
                                    <i class="fas fa-circle {{ !$notifica->conferma_lettura ? 'text-success' : 'text-secondary' }} me-2" style="font-size:.7em"></i>
                                    <span class="flex-grow-1">{{ $notifica->messaggio }}</span>
                                    <span class="text-muted small ms-2">{{ \Carbon\Carbon::parse($notifica->data_creazione)->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <form id="notificheForm" action="{{ route('paziente.notifiche.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success w-100" id="segnaLetteBtn">
                                <i class="fas fa-check-double me-1"></i> Segna tutte come lette
                            </button>
                        </form>
                    @else
                        <div class="text-center text-muted py-4">
                            Nessuna notifica recente
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('notificheForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(resp => resp.json()).then(data => {
                        // Rimuovi badge, aggiorna colori icone
                        document.getElementById('notificheBadge')?.remove();
                        document.querySelectorAll('#notificheList .fa-circle').forEach(i => i.classList.remove('text-success'));
                        document.querySelectorAll('#notificheList .fa-circle').forEach(i => i.classList.add('text-secondary'));
                    });
                });
            }
        });
    </script>
@endsection
