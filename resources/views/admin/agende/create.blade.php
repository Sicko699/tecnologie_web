@extends('layouts.app')
@section('title', 'Aggiungi Slot Agenda')

@section('content')
    <div class="container mt-4">
        <h1>Nuovo Slot Agenda</h1>
        <form action="{{ route('admin.agende.store') }}" method="POST">
            @csrf

            {{-- Dipartimento --}}
            <div class="form-group">
                <label for="id_dipartimento">Dipartimento</label>
                <select name="id_dipartimento" id="id_dipartimento" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($dipartimenti as $d)
                        <option value="{{ $d->id_dipartimento }}" {{ old('id_dipartimento') == $d->id_dipartimento ? 'selected' : '' }}>
                            {{ $d->nome }}
                        </option>
                    @endforeach
                </select>
                @error('id_dipartimento') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- Prestazione --}}
            <div class="form-group mt-2">
                <label for="id_prestazione">Prestazione</label>
                <select name="id_prestazione" id="id_prestazione" class="form-control" required>
                    <option value="">Seleziona</option>
                    @foreach($prestazioni as $prestazione)
                        <option value="{{ $prestazione->id_prestazione }}" {{ old('id_prestazione') == $prestazione->id_prestazione ? 'selected' : '' }}>
                            {{ $prestazione->nome }} ({{ $prestazione->dipartimento->nome }})
                        </option>
                    @endforeach
                </select>
                @error('id_prestazione') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            @php
                $giorni = ['Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'];
                $orariDisponibili = [];
                for ($h = 9; $h < 19; $h++) {
                    $start = sprintf('%02d:00', $h);
                    $end = sprintf('%02d:00', $h+1);
                    $orariDisponibili[] = "$start-$end";
                }
                // Recupera la struttura orari per giorno dal form precedente
                $valoriOrariPerGiorno = old('orari_per_giorno') ? json_decode(old('orari_per_giorno'), true) : [];
            @endphp

            {{-- Sezione per la selezione dei giorni e orari --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Configurazione Slot Orari per Giorno</h5>
                </div>
                <div class="card-body">
                    {{-- Tab navigation per i giorni --}}
                    <ul class="nav nav-tabs" id="giorni-tabs" role="tablist">
                        @foreach($giorni as $idx => $giorno)
                            <li class="nav-item" role="presentation">
                                <a
                                    class="nav-link position-relative {{ $idx === 0 ? 'active' : '' }}"
                                    id="tab-{{ $idx }}"
                                    data-toggle="tab"
                                    href="#giorno-{{ $idx }}"
                                    role="tab"
                                    onclick="cambiaGiorno({{ $idx }})"
                                >
                                    {{ $giorno }}
                                    <span class="badge badge-success ml-2 slot-count-badge" id="badge-{{ $idx }}" style="display: none;">0</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Contenuto dei tab --}}
                    <div class="tab-content mt-3" id="giorni-tab-content">
                        @foreach($giorni as $idx => $giorno)
                            <div class="tab-pane fade {{ $idx === 0 ? 'show active' : '' }}"
                                 id="giorno-{{ $idx }}"
                                 role="tabpanel">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6>Seleziona gli slot orari per {{ $giorno }}</h6>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="selezionaTuttiOrari({{ $idx }})">
                                            Seleziona Tutti
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deselezionaTuttiOrari({{ $idx }})">
                                            Deseleziona Tutti
                                        </button>
                                        @if($idx > 0)
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="copiaOrariDaGiornoPrecedente({{ $idx }})">
                                                Copia da {{ $giorni[$idx-1] }}
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="orari-grid" id="orari-grid-{{ $idx }}">
                                    @foreach($orariDisponibili as $orario)
                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input orario-checkbox"
                                                type="checkbox"
                                                id="orario-{{ $idx }}-{{ $loop->index }}"
                                                value="{{ $orario }}"
                                                data-giorno="{{ $idx }}"
                                                {{ (isset($valoriOrariPerGiorno[$idx]) && in_array($orario, $valoriOrariPerGiorno[$idx])) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="orario-{{ $idx }}-{{ $loop->index }}">
                                                {{ $orario }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-3">
                                    <small class="text-muted">
                                        <span id="count-{{ $idx }}">0</span> slot selezionati per {{ $giorno }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Riepilogo delle selezioni --}}
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6>Riepilogo Slot Selezionati:</h6>
                        <div id="riepilogo-slot">
                            <em class="text-muted">Nessuno slot selezionato</em>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Campo hidden per inviare i dati --}}
            <input type="hidden" id="orari_per_giorno" name="orari_per_giorno" value="{{ old('orari_per_giorno', '{}') }}">
            @error('orari_per_giorno') <div class="text-danger mt-2">{{ $message }}</div> @enderror

            {{-- Max appuntamenti --}}
            <div class="form-group mt-4">
                <label for="max_appuntamenti">Numero massimo appuntamenti per slot</label>
                <input type="number" class="form-control" name="max_appuntamenti" id="max_appuntamenti" min="1" required value="{{ old('max_appuntamenti', 1) }}">
                @error('max_appuntamenti') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" id="submit-btn">Crea Slot Agenda</button>
                <a href="{{ route('admin.agende.index') }}" class="btn btn-secondary">Annulla</a>
            </div>
        </form>
    </div>

    <style>
        .orari-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }

        .form-check-inline {
            margin: 0;
        }

        .nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
        }

        .slot-count-badge {
            font-size: 0.7em;
        }

        .nav-tabs .nav-link {
            cursor: pointer;
        }

        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
        }

        #riepilogo-slot {
            max-height: 200px;
            overflow-y: auto;
        }

        .riepilogo-giorno {
            margin-bottom: 10px;
            padding: 8px;
            background: white;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const giorni = @json($giorni);
            const orariDisponibili = @json($orariDisponibili);

            // Oggetto per memorizzare le selezioni di ogni giorno
            window.orariPerGiorno = {};

            // Inizializza con i valori old se presenti
            try {
                const oldData = document.getElementById('orari_per_giorno').value;
                if (oldData && oldData !== '{}') {
                    window.orariPerGiorno = JSON.parse(oldData);
                }
            } catch (e) {
                console.log('Errore parsing old data:', e);
                window.orariPerGiorno = {};
            }

            // Inizializza gli event listeners per tutti i checkbox
            document.querySelectorAll('.orario-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const giorno = this.dataset.giorno;
                    aggiornaOrariGiorno(giorno);
                });
            });

            // Inizializza l'interfaccia al caricamento
            for (let i = 0; i < giorni.length; i++) {
                aggiornaUI(i);
            }
            aggiornaRiepilogo();

            // Event listener per il submit del form
            document.querySelector('form').addEventListener('submit', function(e) {
                if (Object.keys(window.orariPerGiorno).length === 0) {
                    e.preventDefault();
                    alert('Devi selezionare almeno uno slot orario per almeno un giorno.');
                    return false;
                }
            });
        });

        // Funzione per cambiare giorno (gestisce i tab manualmente)
        function cambiaGiorno(giornoIdx) {
            // Rimuovi active da tutti i tab e pannelli
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Aggiungi active al tab e pannello selezionato
            document.getElementById(`tab-${giornoIdx}`).classList.add('active');
            document.getElementById(`giorno-${giornoIdx}`).classList.add('show', 'active');
        }

        // Funzioni globali per i pulsanti di utilità
        function selezionaTuttiOrari(giornoIdx) {
            const checkboxes = document.querySelectorAll(`input[data-giorno="${giornoIdx}"]`);
            checkboxes.forEach(cb => {
                cb.checked = true;
            });
            aggiornaOrariGiorno(giornoIdx);
        }

        function deselezionaTuttiOrari(giornoIdx) {
            const checkboxes = document.querySelectorAll(`input[data-giorno="${giornoIdx}"]`);
            checkboxes.forEach(cb => {
                cb.checked = false;
            });
            aggiornaOrariGiorno(giornoIdx);
        }

        function copiaOrariDaGiornoPrecedente(giornoIdx) {
            const giornoPrecedente = giornoIdx - 1;
            if (giornoPrecedente >= 0) {
                // Deseleziona tutti i checkbox del giorno corrente
                const checkboxesCorrente = document.querySelectorAll(`input[data-giorno="${giornoIdx}"]`);
                checkboxesCorrente.forEach(cb => cb.checked = false);

                // Seleziona gli stessi orari del giorno precedente
                const checkboxesPrecedente = document.querySelectorAll(`input[data-giorno="${giornoPrecedente}"]:checked`);
                checkboxesPrecedente.forEach(cb => {
                    const valorePrecedente = cb.value;
                    const checkboxCorrispondente = document.querySelector(`input[data-giorno="${giornoIdx}"][value="${valorePrecedente}"]`);
                    if (checkboxCorrispondente) {
                        checkboxCorrispondente.checked = true;
                    }
                });

                aggiornaOrariGiorno(giornoIdx);
            }
        }

        function aggiornaOrariGiorno(giornoIdx) {
            const checkboxes = document.querySelectorAll(`input[data-giorno="${giornoIdx}"]:checked`);
            const orariSelezionati = Array.from(checkboxes).map(cb => cb.value);

            if (orariSelezionati.length > 0) {
                window.orariPerGiorno[giornoIdx] = orariSelezionati;
            } else {
                delete window.orariPerGiorno[giornoIdx];
            }

            aggiornaUI(giornoIdx);
            aggiornaHiddenField();
            aggiornaRiepilogo();
        }

        // Funzione per aggiornare l'interfaccia utente
        function aggiornaUI(giornoIdx) {
            const count = window.orariPerGiorno[giornoIdx] ? window.orariPerGiorno[giornoIdx].length : 0;
            const countElement = document.getElementById(`count-${giornoIdx}`);
            const badgeElement = document.getElementById(`badge-${giornoIdx}`);

            if (countElement) countElement.textContent = count;

            if (badgeElement) {
                if (count > 0) {
                    badgeElement.textContent = count;
                    badgeElement.style.display = 'inline';
                } else {
                    badgeElement.style.display = 'none';
                }
            }
        }

        // Funzione per aggiornare il campo hidden
        function aggiornaHiddenField() {
            document.getElementById('orari_per_giorno').value = JSON.stringify(window.orariPerGiorno);
        }

        // Funzione per aggiornare il riepilogo
        function aggiornaRiepilogo() {
            const giorni = @json($giorni);
            const riepilogoDiv = document.getElementById('riepilogo-slot');
            let html = '';

            let totalSlots = 0;
            Object.keys(window.orariPerGiorno).forEach(giornoIdx => {
                if (window.orariPerGiorno[giornoIdx].length > 0) {
                    totalSlots += window.orariPerGiorno[giornoIdx].length;
                    html += `<div class="riepilogo-giorno">
                        <strong>${giorni[giornoIdx]}:</strong>
                        ${window.orariPerGiorno[giornoIdx].join(', ')}
                    </div>`;
                }
            });

            if (html) {
                html = `<div class="mb-2"><strong>Totale slot: ${totalSlots}</strong></div>` + html;
                riepilogoDiv.innerHTML = html;
            } else {
                riepilogoDiv.innerHTML = '<em class="text-muted">Nessuno slot selezionato</em>';
            }
        }
    </script>
@endsection
