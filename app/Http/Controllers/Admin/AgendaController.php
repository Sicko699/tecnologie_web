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
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'giorno_settimana' => 'required|in:0,1,2,3,4,5',
            'orari' => 'required|string',
            'max_appuntamenti' => 'required|integer|min:1',
        ]);



        $orari = array_map('trim', explode(',', $request->orari));

        foreach ($orari as $orario) {
            if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $orario)) {
                return back()->withErrors(['orari' => "Formato slot orario non valido: $orario"]);
            }

            $agenda = new Agenda([
                'id_dipartimento' => $request->id_dipartimento,
                'id_prestazione' => $request->id_prestazione,
                'giorno_settimana' => $request->giorno_settimana,
                'slot_orario' => $orario,
                'max_appuntamenti' => $request->max_appuntamenti,
            ]);

            if ($agenda->save()) {
                return redirect()->route('admin.agende.index')->with('success', 'Slot agenda creati!');
            } else {
                return back()->withErrors('Errore nel salvataggio dell’agenda.');
            }
        }

    }

    public function edit($id_agenda)
    {
        $agenda = Agenda::findOrFail($id_agenda);
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.edit', compact('agenda', 'dipartimenti', 'prestazioni'));
    }

    public function update(Request $request, $id_agenda)
    {
        $request->validate([
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'giorno_settimana' => 'required|in:0,1,2,3,4,5',
            'slot_orario' => 'required|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
            'max_appuntamenti' => 'required|integer|min:1',
        ]);

        $agenda = Agenda::findOrFail($id_agenda);
        $agenda->update([
            'id_dipartimento' => $request->id_dipartimento,
            'id_prestazione' => $request->id_prestazione,
            'giorno_settimana' => $request->giorno_settimana,
            'slot_orario' => $request->slot_orario,
            'max_appuntamenti' => $request->max_appuntamenti,
        ]);

        return redirect()->route('admin.agende.index')->with('success', 'Slot agende aggiornato!');
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
