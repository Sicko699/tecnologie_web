<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Dipartimento;
use App\Models\Prestazione;
use Illuminate\Http\Request;
use App\Models\Appuntamento;

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

    public function create()
    {
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.create', compact('dipartimenti', 'prestazioni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dipartimento'   => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione'    => 'required|exists:prestazioni,id_prestazione',
            'giorni_settimana'  => 'required|array|min:1',
            'giorni_settimana.*'=> 'integer|between:0,5',
            'orari_per_giorno'  => 'required|string',
            'max_appuntamenti'  => 'required|integer|min:1',
        ]);

        // Decodifica orari_per_giorno in array associativo
        $orariPerGiorno = json_decode($request->orari_per_giorno, true) ?? [];

        Agenda::create([
            'id_dipartimento'   => $request->id_dipartimento,
            'id_prestazione'    => $request->id_prestazione,
            'giorni_settimana'  => $request->giorni_settimana, // array (es: [0,2,4])
            'orari'             => $orariPerGiorno, // array associativo giorno => [orari]
            'max_appuntamenti'  => $request->max_appuntamenti,
        ]);

        return redirect()->route('admin.agende.index')->with('success', 'Agenda creata con successo!');
    }

    public function edit($id_agenda)
    {
        $agenda = Agenda::findOrFail($id_agenda);
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.edit', compact('agenda', 'dipartimenti', 'prestazioni'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_dipartimento'   => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione'    => 'required|exists:prestazioni,id_prestazione',
            'giorni_settimana'  => 'required|array|min:1',
            'giorni_settimana.*'=> 'integer|between:0,5',
            'orari_per_giorno'  => 'required|string',
            'max_appuntamenti'  => 'required|integer|min:1',
        ]);

        $orariPerGiorno = json_decode($request->orari_per_giorno, true) ?? [];

        $agenda = Agenda::findOrFail($id);

        $agenda->update([
            'id_dipartimento'   => $request->id_dipartimento,
            'id_prestazione'    => $request->id_prestazione,
            'giorni_settimana'  => $request->giorni_settimana,
            'orari'             => $orariPerGiorno,
            'max_appuntamenti'  => $request->max_appuntamenti,
        ]);

        return redirect()->route('admin.agende.index')->with('success', 'Agenda aggiornata con successo!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agende.index')->with('success', 'Slot agende eliminato!');
    }

    public function giornaliera($id_agenda, Request $request)
    {
        $agenda = Agenda::with('prestazione')->findOrFail($id_agenda);

        $data = $request->query('data') ?? now()->toDateString();

        // 1) Prendo gli id delle prestazioni legate all'agenda
        $idPrestazioni = $agenda->prestazione->pluck('id_prestazione')->toArray();

        // 2) Prendo gli id delle richieste legate a queste prestazioni
        $idRichieste = \App\Models\Richiesta::whereIn('id_prestazione', $idPrestazioni)->pluck('id_richiesta');

        // 3) Prendo gli appuntamenti di queste richieste e per la data specificata
        $appuntamenti = Appuntamento::with('richiesta.utente')
            ->whereIn('id_richiesta', $idRichieste)
            ->where('data', $data)
            ->get();

        $slotInfo = collect();

        for ($i = 0; $i < $agenda->max_appuntamenti; $i++) {
            $slotOrario = \Carbon\Carbon::parse($agenda->slot_orario)->addMinutes($i * $agenda->durata_slot);

            // Trova appuntamento che ha la stessa ora dello slot (ora è stringa H:i:s)
            $app = $appuntamenti->first(function ($item) use ($slotOrario) {
                return $item->ora === $slotOrario->format('H:i:s');
            });

            $slotInfo->push([
                'slot_orario' => $slotOrario,
                'utente' => $app ? $app->richiesta->utente : null,
                'appuntamento' => $app,
            ]);
        }

        return view('admin.agende.giornaliera', [
            'agenda' => $agenda,
            'data' => $data,
            'slotInfo' => $slotInfo,
        ]);
    }
}
