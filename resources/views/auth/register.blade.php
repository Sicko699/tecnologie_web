@extends('layouts.app')
@section('title', 'Registrazione')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <h2 class="fw-bold mb-4 text-center" style="letter-spacing:.01em;">Registrati</h2>
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
                    @csrf
                    <div class="mb-4">
                        <label for="nome" class="form-label fw-semibold">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" required>
                        @error('nome') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="cognome" class="form-label fw-semibold">Cognome</label>
                        <input type="text" name="cognome" class="form-control" id="cognome" required>
                        @error('cognome') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control" required>
                        @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="sesso" class="form-label fw-semibold">Sesso</label>
                        <select name="sesso" id="sesso" class="form-control" required>
                            <option value="">Seleziona</option>
                            <option value="M">Maschio</option>
                            <option value="F">Femmina</option>
                        </select>
                        @error('sesso') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="data_nascita" class="form-label fw-semibold">Data di nascita</label>
                        <input type="date" name="data_nascita" class="form-control" id="data_nascita" required>
                        @error('data_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4 position-relative">
                        <label for="provincia_nascita" class="form-label fw-semibold">Provincia di nascita</label>
                        <input type="text" name="provincia_nascita" class="form-control" id="provincia_nascita" autocomplete="off" maxlength="2" required>
                        <ul id="prov-suggestions" class="list-group position-absolute w-100" style="z-index:9999; display:none;"></ul>
                        @error('provincia_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4 position-relative">
                        <label for="comune_nascita" class="form-label fw-semibold">Comune di nascita</label>
                        <input type="text" name="comune_nascita" class="form-control" id="comune_nascita" autocomplete="off" required>
                        <ul id="comune-suggestions" class="list-group position-absolute w-100" style="z-index:9999; display:none;"></ul>
                        @error('comune_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="telefono" class="form-label fw-semibold">Telefono</label>
                        <input type="text" name="telefono" class="form-control">
                        @error('telefono') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" required>
                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">Foto Profilo</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        @error('foto') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password" required>
                            <span class="password-toggle" onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        </div>
                        @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Conferma Password</label>
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                            <span class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="codice_fiscale" class="form-label fw-semibold">Codice Fiscale</label>
                        <div class="input-group">
                            <input type="text" name="codice_fiscale" id="codice_fiscale" class="form-control" maxlength="16" readonly required>
                            <button type="button" class="btn btn-secondary" id="cf-check">È corretto?</button>
                        </div>
                        <div id="cf-edit-group" class="mt-2" style="display:none;">
                            <span>Il codice fiscale non è corretto?</span>
                            <button type="button" class="btn btn-warning btn-sm" id="cf-edit-btn">Modifica</button>
                        </div>
                        @error('codice_fiscale') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary px-4 w-100" style="border-radius: 20px;">Registrati</button>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .form-label { font-size: 1.05em; margin-bottom: .3em; }
        .form-select, .form-control {
            border-radius: 12px; font-size: 1em;
            padding: .65em 1em; background: #fafbfc; border: 1px solid #e3e7ef;
        }
        .btn-primary {
            background: #2b79c9; border: none;
            font-weight: 500; letter-spacing: .03em;
        }
        .btn-primary:hover, .btn-primary:focus { background: #185f9e; }
        .password-toggle {
            position: absolute; top: 50%; right: 1.2em; transform: translateY(-50%);
            cursor: pointer; color: #888; font-size: 1.18em; z-index: 10;
            height: 1.8em; display: flex; align-items: center;
        }
        .password-toggle:hover { color: #2b79c9; }
        @media (max-width: 600px) {
            .container { padding-left: 0.6em; padding-right: 0.6em; }
        }
    </style>
    <script>
        function togglePassword(fieldId, el) {
            const input = document.getElementById(fieldId);
            const icon = el.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
@push('scripts')
    <script>
        let comuniItalia = {};
        let province = {};

        // Carica i dati dal file JSON
        async function loadCodiciCatastali() {
            try {
                const response = await fetch('/codici_catastali.json');
                const data = await response.json();

                // Organizza i dati per provincia
                comuniItalia = {};
                province = {};

                data.forEach(item => {
                    const sigla = item.provincia_sigla;

                    // Aggiungi provincia se non esiste
                    if (!province[sigla]) {
                        province[sigla] = sigla; // Puoi sostituire con nome completo se necessario
                    }

                    // Aggiungi comune alla provincia
                    if (!comuniItalia[sigla]) {
                        comuniItalia[sigla] = [];
                    }

                    comuniItalia[sigla].push([item.comune, item.codice]);
                });

                // Ordina i comuni alfabeticamente per ogni provincia
                Object.keys(comuniItalia).forEach(sigla => {
                    comuniItalia[sigla].sort((a, b) => a[0].localeCompare(b[0]));
                });

                console.log('Codici catastali caricati:', Object.keys(comuniItalia).length, 'province');
            } catch (error) {
                console.error('Errore nel caricamento dei codici catastali:', error);
                // Fallback con dati minimi in caso di errore
                province = {
                    'CH': 'Chieti',
                    'RM': 'Roma',
                    'MI': 'Milano'
                };
                comuniItalia = {
                    'CH': [['CHIETI', 'C632']],
                    'RM': [['ROMA', 'H501']],
                    'MI': [['MILANO', 'F205']]
                };
            }
        }

        // --- Autocomplete province ---
        document.addEventListener('DOMContentLoaded', async function() {
            // Carica i dati prima di inizializzare gli autocomplete
            await loadCodiciCatastali();

            const provInput = document.getElementById('provincia_nascita');
            const provBox = document.getElementById('prov-suggestions');

            provInput.addEventListener('input', function() {
                const val = provInput.value.trim().toUpperCase();
                provBox.innerHTML = '';
                if(val.length < 1) {
                    provBox.style.display = 'none';
                    return;
                }

                const filtered = Object.keys(province).filter(p => p.startsWith(val));

                if(filtered.length > 0){
                    filtered.slice(0, 10).forEach(sigla => {
                        const li = document.createElement('li');
                        li.className = "list-group-item list-group-item-action";
                        li.innerText = sigla;
                        li.onclick = () => {
                            provInput.value = sigla;
                            provBox.style.display = 'none';
                            document.getElementById('comune_nascita').value = '';
                            document.getElementById('comune_nascita').removeAttribute('data-catastale');
                            document.getElementById('comune_nascita').focus();
                            generaCF();
                        };
                        provBox.appendChild(li);
                    });
                    provBox.style.display = 'block';
                } else {
                    provBox.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e){
                if(e.target !== provInput) provBox.style.display = 'none';
            });
        });

        // --- Autocomplete comuni in base alla provincia ---
        document.addEventListener('DOMContentLoaded', function() {
            const comuneInput = document.getElementById('comune_nascita');
            const provInput = document.getElementById('provincia_nascita');
            const suggestionsBox = document.getElementById('comune-suggestions');

            comuneInput.addEventListener('input', function() {
                const prov = provInput.value.trim().toUpperCase();
                const val = comuneInput.value.trim().toUpperCase();
                suggestionsBox.innerHTML = '';

                if (!prov || !comuniItalia[prov]) {
                    suggestionsBox.style.display = 'none';
                    return;
                }

                const filtered = comuniItalia[prov].filter(([nome, _]) =>
                    nome.startsWith(val)
                );

                if(filtered.length > 0){
                    filtered.slice(0, 8).forEach(([nome, codice]) => {
                        const li = document.createElement('li');
                        li.className = "list-group-item list-group-item-action";
                        li.innerText = nome;
                        li.onclick = () => {
                            comuneInput.value = nome;
                            suggestionsBox.style.display = 'none';
                            comuneInput.setAttribute('data-catastale', codice);
                            generaCF();
                        };
                        suggestionsBox.appendChild(li);
                    });
                    suggestionsBox.style.display = 'block';
                } else {
                    suggestionsBox.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e){
                if(e.target !== comuneInput) suggestionsBox.style.display = 'none';
            });
        });

        // --- CF generation con carattere di controllo ---
        function generaCF() {
            let nome = document.getElementById('nome').value || '';
            let cognome = document.getElementById('cognome').value || '';
            let sesso = document.getElementById('sesso').value || '';
            let data = document.getElementById('data_nascita').value || '';
            let codiceCatastale = document.getElementById('comune_nascita').getAttribute('data-catastale') || 'Z000';

            if (nome && cognome && sesso && data.length === 10 && codiceCatastale.length === 4) {
                let anno = codificaAnno(data);
                let mese = codificaMese(parseInt(data.substr(5,2),10));
                let giorno = codificaGiorno(data, sesso);
                let cfParziale = codificaCognome(cognome) + codificaNome(nome) + anno + mese + giorno + codiceCatastale;
                let carattereControllo = calcolaCarattereControllo(cfParziale);
                let cfCompleto = cfParziale + carattereControllo;
                document.getElementById('codice_fiscale').value = cfCompleto;
            }
        }

        function codificaCognome(cognome) {
            let cons = cognome.replace(/[^BCDFGHJKLMNPQRSTVWXYZ]/gi, '').toUpperCase();
            let voc = cognome.replace(/[^AEIOU]/gi, '').toUpperCase();
            return (cons + voc + 'XXX').substr(0,3);
        }

        function codificaNome(nome) {
            let cons = nome.replace(/[^BCDFGHJKLMNPQRSTVWXYZ]/gi, '').toUpperCase();
            if (cons.length >= 4) cons = cons[0]+cons[2]+cons[3];
            let voc = nome.replace(/[^AEIOU]/gi, '').toUpperCase();
            return (cons + voc + 'XXX').substr(0,3);
        }

        function codificaAnno(data) {
            return data.substr(2,2);
        }

        function codificaMese(mese) {
            return 'ABCDEHLMPRST'[mese-1];
        }

        function codificaGiorno(data, sesso) {
            let giorno = parseInt(data.substr(8,2),10);
            if (sesso === 'F') giorno += 40;
            return ('0' + giorno).slice(-2);
        }

        // Calcola il carattere di controllo (ultima lettera del CF)
        function calcolaCarattereControllo(cfParziale) {
            // Tabelle di conversione per il calcolo del carattere di controllo
            const valoriPari = {
                '0': 0, '1': 1, '2': 2, '3': 3, '4': 4, '5': 5, '6': 6, '7': 7, '8': 8, '9': 9,
                'A': 0, 'B': 1, 'C': 2, 'D': 3, 'E': 4, 'F': 5, 'G': 6, 'H': 7, 'I': 8, 'J': 9,
                'K': 10, 'L': 11, 'M': 12, 'N': 13, 'O': 14, 'P': 15, 'Q': 16, 'R': 17, 'S': 18,
                'T': 19, 'U': 20, 'V': 21, 'W': 22, 'X': 23, 'Y': 24, 'Z': 25
            };

            const valoriDispari = {
                '0': 1, '1': 0, '2': 5, '3': 7, '4': 9, '5': 13, '6': 15, '7': 17, '8': 19, '9': 21,
                'A': 1, 'B': 0, 'C': 5, 'D': 7, 'E': 9, 'F': 13, 'G': 15, 'H': 17, 'I': 19, 'J': 21,
                'K': 2, 'L': 4, 'M': 18, 'N': 20, 'O': 11, 'P': 3, 'Q': 6, 'R': 8, 'S': 12, 'T': 14,
                'U': 16, 'V': 10, 'W': 22, 'X': 25, 'Y': 24, 'Z': 23
            };

            const caratteriControllo = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            let somma = 0;

            // Somma i valori delle posizioni dispari (1°, 3°, 5°, etc.)
            for (let i = 0; i < cfParziale.length; i += 2) {
                somma += valoriDispari[cfParziale[i]] || 0;
            }

            // Somma i valori delle posizioni pari (2°, 4°, 6°, etc.)
            for (let i = 1; i < cfParziale.length; i += 2) {
                somma += valoriPari[cfParziale[i]] || 0;
            }

            // Il carattere di controllo è dato dal resto della divisione per 26
            return caratteriControllo[somma % 26];
        }

        // Aggiorna CF a ogni cambio
        ['nome', 'cognome', 'sesso', 'data_nascita', 'comune_nascita', 'provincia_nascita'].forEach(id => {
            document.addEventListener('DOMContentLoaded', () => {
                let el = document.getElementById(id);
                if (el) el.addEventListener('input', generaCF);
            });
        });

        // Bottone "è corretto?" e "modifica"
        document.addEventListener('DOMContentLoaded', () => {
            const checkBtn = document.getElementById('cf-check');
            const editBtn = document.getElementById('cf-edit-btn');

            if (checkBtn) {
                checkBtn.onclick = function() {
                    document.getElementById('cf-edit-group').style.display = 'block';
                };
            }

            if (editBtn) {
                editBtn.onclick = function() {
                    let cf = document.getElementById('codice_fiscale');
                    cf.readOnly = false;
                    cf.focus();
                };
            }
        });
    </script>
@endpush
