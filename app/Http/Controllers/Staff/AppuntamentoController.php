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

    public function create($id_richiesta)
    {
        $richiesta = Richiesta::with(['utente', 'prestazione'])->findOrFail($id_richiesta);
        return view('staff.appuntamenti.create', compact('richiesta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date',
            'ora' => 'required',
        ]);
        $appuntamento = Appuntamento::create([
            'id_richiesta' => $request->id_richiesta,
            'data' => $request->data,
            'ora' => $request->ora,
            'stato' => 'prenotato',
        ]);
        $richiesta = Richiesta::find($request->id_richiesta);
        $richiesta->stato = 'in agenda';
        $richiesta->save();

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
