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
                ->whereHas('richiesta', function($q) use ($id_prestazione) {
                    $q->where('id_prestazione', $id_prestazione);
                })
                ->with(['richiesta.utente', 'richiesta.prestazione'])
                ->get();
        }

        return view('staff.agenda.giornaliera', compact('appuntamenti', 'giorno', 'prestazioni', 'id_prestazione'));
    }
}
