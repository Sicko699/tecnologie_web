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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppuntamentoController extends Controller
{
    public function richiestePendenti()
    {
        $richieste = Richiesta::where('stato', 'in attesa')->with(['utente', 'prestazione'])->get();
        return view('staff.richieste.index', compact('richieste'));
    }

    public function create($id_richiesta, Request $request)
    {
        $richiesta = Richiesta::with(['prestazione', 'utente'])->findOrFail($id_richiesta);

        $agenda = Agenda::where('id_prestazione', $richiesta->id_prestazione)->first();
        if (!$agenda) {
            return redirect()->route('staff.richieste.index')
                ->with('error', 'Non esiste un\'agenda per questa prestazione.');
        }
        $configurazione = $agenda->configurazione_orari;
        $giorniSettimana = $agenda->giorni_settimana;
        $giornoEscluso = $richiesta->giorno_escluso;

        $dataSelezionata = $request->input('data', now()->toDateString());
        $carbonData = Carbon::parse($dataSelezionata);
        $giornoData = ucfirst($carbonData->locale('it')->dayName);

        $slotDisponibili = [];
        $erroreGiornoEscluso = null;

        // Trova la prima data disponibile e il primo slot disponibile
        $primaDataDisponibile = null;
        $primoSlotDisponibile = null;
        $maxSearchDays = 30; // cerca fino a 30 giorni avanti per sicurezza

        for ($i = 0; $i < $maxSearchDays; $i++) {
            $testDate = now()->copy()->addDays($i)->toDateString();
            $carbonTestDate = Carbon::parse($testDate);
            $giornoTest = ucfirst($carbonTestDate->locale('it')->dayName);

            // Salta se è il giorno escluso
            if ($giornoEscluso && $giornoTest === $giornoEscluso) continue;

            // Cerca posizione del giorno nella configurazione agenda
            $idxInAgenda = array_search($giornoTest, $giorniSettimana);
            if ($idxInAgenda === false) continue;

            $slotGiorno = $configurazione[$idxInAgenda] ?? [];

            // Calcola orario attuale solo per oggi
            $isToday = $testDate === now()->toDateString();
            $oraAttuale = now()->format('H:i');

            // Cerca il primo slot disponibile in questo giorno
            foreach ($slotGiorno as $slot) {
                $oraInizio = explode('-', $slot)[0];
                if (strlen($oraInizio) === 5) $oraInizio .= ':00';

                // Salta slot già passati se oggi
                if ($isToday && $oraInizio <= $oraAttuale) continue;

                // Conta appuntamenti prenotati
                $countPrenotati = Appuntamento::where('data', $testDate)
                    ->where('ora', $oraInizio)
                    ->whereHas('richiesta', function ($q) use ($richiesta) {
                        $q->where('id_prestazione', $richiesta->id_prestazione);
                    })
                    ->count();

                if ($countPrenotati < $agenda->max_appuntamenti) {
                    // Primo slot trovato!
                    $primaDataDisponibile = $testDate;
                    $primoSlotDisponibile = $slot;
                    break 2; // esci sia dal foreach che dal for
                }
            }
        }
// Fallback: se nulla trovato, lascia default today/data selezionata
        if (!$primaDataDisponibile) $primaDataDisponibile = now()->toDateString();

        $dataSelezionata = $request->input('data', $primaDataDisponibile);

// Ora ricalcola gli slot disponibili PER LA DATA SELEZIONATA
        $carbonData = Carbon::parse($dataSelezionata);
        $giornoData = ucfirst($carbonData->locale('it')->dayName);

        $slotDisponibili = [];
        $erroreGiornoEscluso = null;

        if ($giornoEscluso && $giornoData === $giornoEscluso) {
            $erroreGiornoEscluso = $giornoEscluso;
        } else {
            $idxInAgenda = array_search($giornoData, $giorniSettimana);
            if ($idxInAgenda !== false) {
                $slotGiorno = $configurazione[$idxInAgenda] ?? [];
                $isToday = $dataSelezionata === now()->toDateString();
                $oraAttuale = now()->format('H:i');

                foreach ($slotGiorno as $slot) {
                    $oraInizio = explode('-', $slot)[0];
                    if (strlen($oraInizio) === 5) $oraInizio .= ':00';

                    if ($isToday && $oraInizio <= $oraAttuale) {
                        continue;
                    }

                    $countPrenotati = Appuntamento::where('data', $dataSelezionata)
                        ->where('ora', $oraInizio)
                        ->whereHas('richiesta', function ($q) use ($richiesta) {
                            $q->where('id_prestazione', $richiesta->id_prestazione);
                        })
                        ->count();

                    if ($countPrenotati < $agenda->max_appuntamenti) {
                        $slotDisponibili[] = $slot;
                    }
                }
            }
        }

// Passa il primo slot valido, se trovato, alla view
        $primoSlotView = old('ora') ?? $primoSlotDisponibile ?? (count($slotDisponibili) > 0 ? reset($slotDisponibili) : null);

        return view('staff.appuntamenti.create', [
            'richiesta' => $richiesta,
            'agenda' => $agenda,
            'dataSelezionata' => $dataSelezionata,
            'slotDisponibili' => $slotDisponibili,
            'giornoEscluso' => $giornoEscluso,
            'erroreGiornoEscluso' => $erroreGiornoEscluso,
            'giorniSettimana' => $giorniSettimana,
            'primoSlotView' => $primoSlotView,
        ]);

    }


    public function store(Request $request)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date|after_or_equal:today',
            'ora' => 'required',
        ]);

        $richiesta = Richiesta::with('utente')->findOrFail($request->id_richiesta);
        $giornoEscluso = $richiesta->giorno_escluso;
        $agenda = Agenda::where('id_prestazione', $richiesta->id_prestazione)->firstOrFail();

        $data = $request->data;
        $slot = $request->ora;

        $oraInizio = explode('-', $slot)[0];
        if (strlen($oraInizio) === 5) $oraInizio .= ':00';

        $carbonData = Carbon::parse($data);
        $giornoData = ucfirst($carbonData->locale('it')->dayName);
        if ($giornoData === $giornoEscluso) {
            return back()->withErrors(['data' => 'Non puoi prenotare in questo giorno: l utente lo ha escluso.'])->withInput();
        }

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

        DB::transaction(function () use ($richiesta, $data, $oraInizio) {
            $app = new Appuntamento();
            $app->id_richiesta = $richiesta->id_richiesta;
            $app->data = $data;
            $app->ora = $oraInizio;
            $app->stato = 'prenotato';
            $app->codice_fiscale = $richiesta->utente->codice_fiscale;
            $app->save();

            $richiesta->stato = 'confermato';
            $richiesta->save();

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
        Appuntamento::aggiornaErogati();

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
            'ora' => 'required',
            'stato' => 'required'
        ]);

        $oraInizio = explode('-', $request->ora)[0];
        if (strlen($oraInizio) === 5) $oraInizio .= ':00';

        $appuntamento->update([
            'data' => $request->data,
            'ora' => $oraInizio,
            'stato' => $request->stato,
            'codice_fiscale' => $appuntamento->richiesta->utente->codice_fiscale,
        ]);

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
        Notifica::create([
            'codice_fiscale' => $appuntamento->richiesta->utente->codice_fiscale,
            'messaggio' => 'Il tuo appuntamento del ' . $appuntamento->data . ' è stato annullato dallo staff!',
            'data_creazione' => now(),
            'conferma_lettura' => false
        ]);

        $appuntamento->delete();
        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento eliminato!');
    }

    public function agendaGiornaliera(Request $request)
    {
        $user = Auth::user();
        $membro = $user->membroStaff;

        if (!$membro) {
            abort(403, 'Non sei associato a nessun dipartimento.');
        }

        $prestazioni = Prestazione::where('id_dipartimento', $membro->id_dipartimento)->get();

        $giorno = $request->input('giorno', now()->toDateString());
        $id_prestazione = $request->input('id_prestazione');
        $appuntamenti = collect();

        if ($id_prestazione && $giorno) {
            $appuntamenti = Appuntamento::where('data', $giorno)
                ->where('stato', '!=', 'erogato')
                ->get();
            //dd($id_prestazione, $giorno,$appuntamenti);
        }

        return view('staff.agenda.giornaliera', compact('appuntamenti', 'giorno', 'prestazioni', 'id_prestazione'));
    }
}
