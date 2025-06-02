<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appuntamento;
use App\Models\Richiesta;
use App\Models\Notifica;
use App\Models\Prestazione;
use Illuminate\Http\Request;

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
        $richiesta = \App\Models\Richiesta::with(['utente', 'prestazione'])->findOrFail($id_richiesta);
        $agenda = \App\Models\Agenda::where('id_prestazione', $richiesta->id_prestazione)->firstOrFail();
        $dataSelezionata = $request->input('data', now()->toDateString());

        // Giorno della settimana (0 = lunedì, 6 = domenica)
        $dayOfWeek = \Carbon\Carbon::parse($dataSelezionata)->dayOfWeek;
        $giornoMappato = $dayOfWeek === 0 ? 6 : $dayOfWeek - 1;

        $slotOrari = $agenda->configurazione_orari[$giornoMappato] ?? [];

        // Filtra solo slot con posti disponibili
        $slotDisponibili = [];
        foreach ($slotOrari as $slot) {
            $oraInizio = explode('-', $slot)[0];
            $appPrenotati = \App\Models\Appuntamento::where('data', $dataSelezionata)
                ->where('ora', $oraInizio . ':00')
                ->whereHas('richiesta', fn($q) => $q->where('id_prestazione', $richiesta->id_prestazione))
                ->count();
            if ($appPrenotati < $agenda->max_appuntamenti) {
                $slotDisponibili[] = $slot;
            }
        }

        return view('staff.appuntamenti.create', compact('richiesta', 'agenda', 'slotDisponibili', 'dataSelezionata'));
    }

// Store - salva l'appuntamento, valida che lo slot sia ancora disponibile
    public function store(Request $request)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date|after_or_equal:today',
            'ora'  => 'required'
        ]);

        $richiesta = \App\Models\Richiesta::findOrFail($request->id_richiesta);
        $agenda = \App\Models\Agenda::where('id_prestazione', $richiesta->id_prestazione)->firstOrFail();

        // Giorno della settimana
        $dayOfWeek = \Carbon\Carbon::parse($request->data)->dayOfWeek;
        $giornoMappato = $dayOfWeek === 0 ? 6 : $dayOfWeek - 1;
        $slotOrari = $agenda->configurazione_orari[$giornoMappato] ?? [];

        // Controlla che la slot scelta sia tra quelle dell’agenda
        $oraSelezionata = collect($slotOrari)->filter(function($slot) use ($request) {
            return explode('-', $slot)[0] . ':00' === $request->ora;
        })->first();

        if (!$oraSelezionata) {
            return back()->withErrors(['ora' => 'Orario non valido per il giorno selezionato!'])->withInput();
        }

        // Controlla che non sia pieno
        $appPrenotati = \App\Models\Appuntamento::where('data', $request->data)
            ->where('ora', $request->ora)
            ->whereHas('richiesta', fn($q) => $q->where('id_prestazione', $richiesta->id_prestazione))
            ->count();

        if ($appPrenotati >= $agenda->max_appuntamenti) {
            return back()->withErrors(['ora' => 'Slot orario già pieno!'])->withInput();
        }

        // CREA appuntamento
        $appuntamento = \App\Models\Appuntamento::create([
            'id_richiesta' => $request->id_richiesta,
            'data' => $request->data,
            'ora'  => $request->ora,
            'stato' => 'prenotato',
        ]);

        $richiesta->stato = 'in agenda';
        $richiesta->save();

        // (Eventuale) Notifica
        \App\Models\Notifica::create([
            'id_utente' => $richiesta->id_utente,
            'messaggio' => 'È stato fissato un appuntamento per la tua richiesta il ' . $request->data . ' alle ' . $request->ora,
            'data_creazione' => now(),
            'conferma_lettura' => false,
        ]);

        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento inserito!');
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
            'ora' => 'required',
            'stato' => 'required'
        ]);
        $appuntamento->update([
            'data' => $request->data,
            'ora' => $request->ora,
            'stato' => $request->stato,
        ]);
        // NOTIFICA all'utente
        Notifica::create([
            'utente_id' => $appuntamento->richiesta->id_utente,
            'messaggio' => 'Il tuo appuntamento del ' . $appuntamento->data . ' è stato modificato!',
            'letta' => false
        ]);
        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento aggiornato!');
    }

    public function destroy(Appuntamento $appuntamento)
    {
        Notifica::create([
            'utente_id' => $appuntamento->richiesta->id_utente,
            'messaggio' => 'Il tuo appuntamento del ' . $appuntamento->data . ' è stato annullato dallo staff!',
            'letta' => false
        ]);
        $appuntamento->delete();
        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento eliminato!');
    }

    // FORM per scegliere prestazione e giorno (agenda giornaliera)
    public function agendaGiornalieraForm()
    {
        $prestazioni = Prestazione::all();
        return view('staff.agenda.giornaliera_form', compact('prestazioni'));
    }

    // Visualizzazione agenda giornaliera per prestazione e giorno
    public function agendaGiornaliera(Request $request)
    {
        $id_prestazione = $request->input('id_prestazione');
        $giorno = $request->input('giorno');

        $appuntamenti = Appuntamento::where('data', $giorno)
            ->where('stato', '!=', 'erogato')
            ->whereHas('richiesta', function($q) use ($id_prestazione) {
                $q->where('id_prestazione', $id_prestazione);
            })
            ->with(['richiesta.utente', 'richiesta.prestazione'])
            ->get();

        return view('staff.agenda.giornaliera', compact('appuntamenti', 'giorno'));
    }
}
