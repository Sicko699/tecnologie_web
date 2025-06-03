<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Dipartimento;
use App\Models\Prestazione;
use Illuminate\Http\Request;
use App\Models\Appuntamento;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $agende = Agenda::with(['dipartimento', 'prestazione'])->get();
        return view('admin.agende.index', compact('agende'));
    }

    public function create(Request $request)
    {
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        $selectedDipartimento = $request->query('id_dipartimento');
        $selectedPrestazione = $request->query('id_prestazione');
        return view('admin.agende.create', compact('dipartimenti', 'prestazioni', 'selectedDipartimento', 'selectedPrestazione'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dipartimento'   => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione'    => 'required|exists:prestazioni,id_prestazione',
            'orari_per_giorno'  => 'required|string',
            'max_appuntamenti'  => 'required|integer|min:1',
        ]);

        $orariPerGiorno = json_decode($request->orari_per_giorno, true);

        if (empty($orariPerGiorno)) {
            return back()->withErrors(['orari_per_giorno' => 'Devi selezionare almeno uno slot orario.'])->withInput();
        }

        $prestazione = Prestazione::where('id_prestazione', $request->id_prestazione)
            ->where('id_dipartimento', $request->id_dipartimento)
            ->first();

        if (!$prestazione) {
            return back()->withErrors(['id_prestazione' => 'La prestazione non appartiene al dipartimento selezionato.'])->withInput();
        }

        Agenda::create([
            'id_dipartimento'     => $request->id_dipartimento,
            'id_prestazione'      => $request->id_prestazione,
            'configurazione_orari' => $orariPerGiorno,
            'max_appuntamenti'    => $request->max_appuntamenti,
        ]);

        return redirect()->route('admin.agende.index')->with('success', 'Agenda creata con successo!');
    }

    public function show(Agenda $agende)
    {
        return view('admin.agende.show', ['agenda' => $agende]);
    }

    public function edit(Agenda $agende)
    {
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.edit', [
            'agenda' => $agende,
            'dipartimenti' => $dipartimenti,
            'prestazioni' => $prestazioni
        ]);
    }

    public function update(Request $request, Agenda $agende)
    {
        $request->validate([
            'id_dipartimento'   => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione'    => 'required|exists:prestazioni,id_prestazione',
            'orari_per_giorno'  => 'required|string',
            'max_appuntamenti'  => 'required|integer|min:1',
        ]);

        $orariPerGiorno = json_decode($request->orari_per_giorno, true);

        if (empty($orariPerGiorno)) {
            return back()->withErrors(['orari_per_giorno' => 'Devi selezionare almeno uno slot orario.'])->withInput();
        }

        $agende->update([
            'id_dipartimento'     => $request->id_dipartimento,
            'id_prestazione'      => $request->id_prestazione,
            'configurazione_orari' => $orariPerGiorno,
            'max_appuntamenti'    => $request->max_appuntamenti,
        ]);

        return redirect()->route('admin.agende.index')->with('success', 'Agenda aggiornata con successo!');
    }

    public function destroy(Agenda $agende)
    {
        $appuntamentiFuturi = Appuntamento::whereHas('richiesta', function($query) use ($agende) {
            $query->where('id_prestazione', $agende->id_prestazione);
        })->where('data', '>=', now()->toDateString())->count();

        if ($appuntamentiFuturi > 0) {
            return back()->withErrors(['delete' => 'Impossibile eliminare: esistono appuntamenti futuri collegati a questa agenda.']);
        }

        $agende->delete();
        return redirect()->route('admin.agende.index')->with('success', 'Agenda eliminata con successo!');
    }

    // Gli altri metodi non resource rimangono come sono
    public function giornaliera($id_agenda, Request $request)
    {
        $agenda = Agenda::with(['prestazione', 'dipartimento'])->findOrFail($id_agenda);
        $data = $request->query('data', now()->toDateString());

        $dataCarbon = Carbon::parse($data);
        $giornoSettimana = $dataCarbon->dayOfWeek;
        $giornoMappato = $giornoSettimana === 0 ? 6 : $giornoSettimana - 1;

        $configurazione = $agenda->configurazione_orari;
        $slotGiorno = $configurazione[$giornoMappato] ?? [];

        if (empty($slotGiorno)) {
            return view('admin.agende.giornaliera', [
                'agenda' => $agenda,
                'data' => $data,
                'slotInfo' => collect(),
                'message' => 'Nessuno slot disponibile per questo giorno.'
            ]);
        }

        $appuntamenti = Appuntamento::with('richiesta.utente')
            ->whereHas('richiesta', function($query) use ($agenda) {
                $query->where('id_prestazione', $agenda->id_prestazione);
            })
            ->where('data', $data)
            ->get()
            ->keyBy('ora');

        $slotInfo = collect();

        foreach ($slotGiorno as $slot) {
            [$oraInizio, $oraFine] = explode('-', $slot);
            $oraCompleta = $oraInizio . ':00';

            $appuntamentiSlot = $appuntamenti->filter(function($app) use ($oraCompleta) {
                return $app->ora === $oraCompleta;
            });

            $slotInfo->push([
                'slot' => $slot,
                'ora_inizio' => $oraInizio,
                'ora_fine' => $oraFine,
                'appuntamenti_prenotati' => $appuntamentiSlot->count(),
                'posti_disponibili' => $agenda->max_appuntamenti - $appuntamentiSlot->count(),
                'appuntamenti' => $appuntamentiSlot->values(),
                'completo' => $appuntamentiSlot->count() >= $agenda->max_appuntamenti
            ]);
        }

        return view('admin.agende.giornaliera', [
            'agenda' => $agenda,
            'data' => $data,
            'slotInfo' => $slotInfo,
            'nomeGiorno' => $dataCarbon->locale('it')->dayName
        ]);
    }

    public function getSlotDisponibili($id_agenda, $data)
    {
        $agenda = Agenda::findOrFail($id_agenda);
        $dataCarbon = Carbon::parse($data);
        $giornoMappato = $dataCarbon->dayOfWeek === 0 ? 6 : $dataCarbon->dayOfWeek - 1;

        $configurazione = $agenda->configurazione_orari;
        return $configurazione[$giornoMappato] ?? [];
    }
}
