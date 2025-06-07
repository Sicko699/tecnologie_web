<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Appuntamento;
use App\Models\Richiesta;
use App\Models\Notifica;
use App\Models\Prestazione;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppuntamentoController extends Controller
{
    public function richiestePendenti()
    {
        $richieste = Richiesta::where('stato', 'in attesa')->with(['utente', 'prestazione'])->get();
        return view('staff.richieste.index', compact('richieste'));
    }

    // Mostra il form per assegnare un appuntamento a una richiesta utente
    public function create($id_richiesta, Request $request)
    {
        $richiesta = Richiesta::with(['prestazione', 'utente'])->findOrFail($id_richiesta);
        //dd('Trovata richiesta', $richiesta);

        $agenda = Agenda::where('id_prestazione', $richiesta->id_prestazione)->first();
        if (!$agenda) {
            return redirect()->route('staff.richieste.index')
                ->with('error', 'Non esiste un\'agenda per questa prestazione.');
        }
        //dd('Trovata agenda', $agenda);
        $configurazione = $agenda->configurazione_orari;     // array di array slot per ogni giorno
        //dd($configurazione);
        $giorniSettimana = $agenda->giorni_settimana;        // array tipo ['Lunedì', 'Martedì', ...]
        $giornoEscluso = $richiesta->giorno_escluso;         // es. 'Martedì' o null

        $giorniSettimana = $agenda->giorni_settimana; // array tipo ['Lunedì', 'Martedì', ...]

        // Data selezionata dal form, oppure oggi
        $dataSelezionata = $request->input('data', now()->toDateString());
        $carbonData = Carbon::parse($dataSelezionata);
        $giornoData = ucfirst($carbonData->locale('it')->dayName); // 'Lunedì', ...

        // Variabili di ritorno
        $slotDisponibili = [];
        $erroreGiornoEscluso = null;

        // 1. Controllo: la data selezionata è il giorno escluso dall'utente?
        if ($giornoEscluso && $giornoData === $giornoEscluso) {
            $erroreGiornoEscluso = $giornoEscluso;
        } else {
            // 2. La data selezionata è tra i giorni lavorativi dell'agenda?
            $idxInAgenda = array_search($giornoData, $giorniSettimana);
            if ($idxInAgenda !== false) {
                // 3. Recupera gli slot previsti per quel giorno dall'agenda
                $slotGiorno = $configurazione[$idxInAgenda] ?? [];
                foreach ($slotGiorno as $slot) {
                    $oraInizio = explode('-', $slot)[0];
                    if (strlen($oraInizio) === 5) $oraInizio .= ':00';

                    $countPrenotati = Appuntamento::where('data', $dataSelezionata)
                        ->where('ora', $oraInizio)
                        ->whereHas('richiesta', function ($q) use ($richiesta) {
                            $q->where('id_prestazione', $richiesta->id_prestazione);
                        })
                        ->count();

                    if ($countPrenotati < $agenda->max_appuntamenti) {
                        $slotDisponibili[] = $slot; // ora lo slot è es "09:00-10:00"
                    }
                }
            }
        }

        return view('staff.appuntamenti.create', [
            'richiesta' => $richiesta,
            'agenda' => $agenda,
            'dataSelezionata' => $dataSelezionata,
            'slotDisponibili' => $slotDisponibili,
            'giornoEscluso' => $giornoEscluso,
            'erroreGiornoEscluso' => $erroreGiornoEscluso,
            'giorniSettimana' => $giorniSettimana,
        ]);

    }

    // Store - salva l'appuntamento, valida che lo slot sia ancora disponibile
    public function store(Request $request)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date|after_or_equal:today',
            'ora' => 'required', // ora è lo slot intero es. "09:00-10:00"
        ]);

        $richiesta = Richiesta::with('utente')->findOrFail($request->id_richiesta);
        $giornoEscluso = $richiesta->giorno_escluso;
        $agenda = Agenda::where('id_prestazione', $richiesta->id_prestazione)->firstOrFail();

        $data = $request->data;
        $slot = $request->ora; // es "09:00-10:00"

        // Estrai ora di inizio in formato hh:mm:00
        $oraInizio = explode('-', $slot)[0];
        if (strlen($oraInizio) === 5) $oraInizio .= ':00';

        $carbonData = Carbon::parse($data);
        $giornoData = ucfirst($carbonData->locale('it')->dayName);
        if ($giornoData === $giornoEscluso) {
            return back()->withErrors(['data' => 'Non puoi prenotare in questo giorno: l utente lo ha escluso.'])->withInput();
        }

        // Trova max appuntamenti consentiti per quello slot
        $maxAppuntamenti = $agenda->max_appuntamenti;
        $countPrenotati = Appuntamento::where('data', $data)
            ->where('ora', $oraInizio)
            ->whereHas('richiesta', function ($q) use ($richiesta) {
                $q->where('id_prestazione', $richiesta->id_prestazione);
            })
            ->count();

        if ($countPrenotati >= $maxAppuntamenti) {
            return back()->withErrors(['ora' => 'Slot orario già pieno, scegli un altro orario.'])->withInput();
        }

        // CREA appuntamento e aggiorna richiesta (transazione!)
        DB::transaction(function () use ($richiesta, $data, $oraInizio) {
            $app = new Appuntamento();
            $app->id_richiesta = $richiesta->id_richiesta;
            $app->data = $data;
            $app->ora = $oraInizio;
            $app->stato = 'prenotato';
            $app->codice_fiscale = $richiesta->utente->codice_fiscale; // <-- AGGIUNGI QUESTO
            $app->save();

            // Aggiorna stato richiesta
            $richiesta->stato = 'confermato';
            $richiesta->save();

            // NOTIFICA all'utente - CAMPI CORRETTI
            Notifica::create([
                'codice_fiscale' => $richiesta->utente->codice_fiscale,
                'messaggio' => 'Il tuo appuntamento è stato confermato per il ' . $data . ' alle ' . $oraInizio,
                'data_creazione' => now(),
                'conferma_lettura' => false
            ]);
        });

        return redirect()->route('staff.richieste.index')->with('success', 'Appuntamento assegnato!');
    }

    public function index()
    {
        $appuntamenti = Appuntamento::with(['richiesta.utente', 'richiesta.prestazione'])->get();
        return view('staff.appuntamenti.index', compact('appuntamenti'));
    }

    public function edit(Appuntamento $appuntamento)
    {
        $appuntamento->load(['richiesta.utente', 'richiesta.prestazione']);
        return view('staff.appuntamenti.edit', compact('appuntamento'));
    }

    public function update(Request $request, Appuntamento $appuntamento)
    {
        $request->validate([
            'data' => 'required|date',
            'ora' => 'required', // anche qui sarà slot tipo "09:00-10:00"
            'stato' => 'required'
        ]);
        // Estrai ora di inizio
        $oraInizio = explode('-', $request->ora)[0];
        if (strlen($oraInizio) === 5) $oraInizio .= ':00';

        $appuntamento->update([
            'data' => $request->data,
            'ora' => $oraInizio,
            'stato' => $request->stato,
            'codice_fiscale' => $appuntamento->richiesta->utente->codice_fiscale,
        ]);


        // NOTIFICA all'utente - CAMPI CORRETTI
        Notifica::create([
            'codice_fiscale' => $appuntamento->richiesta->utente->codice_fiscale,
            'messaggio' => 'Il tuo appuntamento del ' . $appuntamento->data . ' è stato modificato!',
            'data_creazione' => now(),
            'conferma_lettura' => false
        ]);

        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento aggiornato!');
    }

    public function destroy(Appuntamento $appuntamento)
    {
        // NOTIFICA all'utente - CAMPI CORRETTI
        Notifica::create([
            'codice_fiscale' => $appuntamento->richiesta->utente->codice_fiscale,
            'messaggio' => 'Il tuo appuntamento del ' . $appuntamento->data . ' è stato annullato dallo staff!',
            'data_creazione' => now(),
            'conferma_lettura' => false
        ]);

        $appuntamento->delete();
        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento eliminato!');
    }

    // Visualizzazione agenda giornaliera per prestazione e giorno
    public function agendaGiornaliera(Request $request)
    {
        //dd($request);
        $prestazioni = Prestazione::all();
        $appuntamenti = null;
        $giorno = $request->input('giorno');
        $id_prestazione = $request->input('id_prestazione');

        if (!empty($id_prestazione) && !empty($giorno)) {
            $appuntamenti = Appuntamento::where('data', $giorno)
                ->where('stato', '!=', 'erogato')
                ->whereHas('richiesta', function($q) use ($id_prestazione) {
                    $q->where('id_prestazione', $id_prestazione);
                })
                ->with(['richiesta.utente', 'richiesta.prestazione'])
                ->get();
        }

        return view('staff.agenda.giornaliera', compact('appuntamenti', 'giorno', 'prestazioni'));
    }
}
