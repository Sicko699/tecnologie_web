@extends('layouts.app')
@section('title', 'Registrazione')
@section('content')
    <div class="container py-5">
        <h2>Registrati</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm">
            @csrf
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" required>
                @error('nome') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" name="cognome" class="form-control" id="cognome" required>
                @error('cognome') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="sesso" class="form-label">Sesso</label>
                <select name="sesso" id="sesso" class="form-control" required>
                    <option value="">Seleziona</option>
                    <option value="M">Maschio</option>
                    <option value="F">Femmina</option>
                </select>
                @error('sesso') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="data_nascita" class="form-label">Data di nascita</label>
                <input type="date" name="data_nascita" class="form-control" id="data_nascita" required>
                @error('data_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3 position-relative">
                <label for="provincia_nascita" class="form-label">Provincia di nascita</label>
                <input type="text" name="provincia_nascita" class="form-control" id="provincia_nascita" autocomplete="off" maxlength="2" required>
                <ul id="prov-suggestions" class="list-group position-absolute w-100" style="z-index:9999; display:none;"></ul>
                @error('provincia_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3 position-relative">
                <label for="comune_nascita" class="form-label">Comune di nascita</label>
                <input type="text" name="comune_nascita" class="form-control" id="comune_nascita" autocomplete="off" required>
                <ul id="comune-suggestions" class="list-group position-absolute w-100" style="z-index:9999; display:none;"></ul>
                @error('comune_nascita') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" name="telefono" class="form-control">
                @error('telefono') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profilo</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                @error('foto') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Conferma Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            {{-- Codice fiscale (ultimo campo, autogenerato) --}}
            <div class="mb-3">
                <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
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
            <button type="submit" class="btn btn-primary">Registrati</button>
        </form>
    </div>
@endsection

@push('scripts')
    @php
        // Demo: province e comuni minimi (amplia pure da file o DB)
        $province = [
            'CH' => 'Chieti',
            'RM' => 'Roma',
            'MI' => 'Milano',
            // ... altre province
        ];
        $comuniItalia = [
            'CH' => [
                ['CHIETI', 'C632'],
                ['FRANCAVILLA AL MARE', 'D762'],
                // ... altri comuni
            ],
            'RM' => [
                ['ROMA', 'H501'],
                ['FIUMICINO', 'M297'],
            ],
            'MI' => [
                ['MILANO', 'F205'],
                ['SEGRATE', 'I589'],
            ],
        ];
    @endphp
    <script>
        const province = @json($province);
        const comuniItalia = @json($comuniItalia);

        // --- Autocomplete province ---
        document.addEventListener('DOMContentLoaded', function() {
            const provInput = document.getElementById('provincia_nascita');
            const provBox = document.getElementById('prov-suggestions');
            provInput.addEventListener('input', function() {
                const val = provInput.value.trim().toUpperCase();
                provBox.innerHTML = '';
                if(val.length < 1) { provBox.style.display = 'none'; return; }
                const filtered = Object.keys(province).filter(p => p.startsWith(val));
                if(filtered.length > 0){
                    filtered.forEach(sigla => {
                        const li = document.createElement('li');
                        li.className = "list-group-item list-group-item-action";
                        li.innerText = sigla + ' – ' + province[sigla];
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
                const filtered = comuniItalia[prov].filter(([nome, _]) => nome.startsWith(val));
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

        // --- CF generation aggiornata ---
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
                let cf = codificaCognome(cognome) + codificaNome(nome) + anno + mese + giorno + codiceCatastale;
                document.getElementById('codice_fiscale').value = cf.substr(0,16);
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
        function codificaAnno(data) { return data.substr(2,2); }
        function codificaMese(mese) { return 'ABCDEHLMPRST'[mese-1]; }
        function codificaGiorno(data, sesso) {
            let giorno = parseInt(data.substr(8,2),10);
            if (sesso === 'F') giorno += 40;
            return ('0' + giorno).slice(-2);
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
            document.getElementById('cf-check').onclick = function() {
                document.getElementById('cf-edit-group').style.display = 'block';
            };
            document.getElementById('cf-edit-btn').onclick = function() {
                let cf = document.getElementById('codice_fiscale');
                cf.readOnly = false;
                cf.focus();
            };
        });
    </script>
@endpush
