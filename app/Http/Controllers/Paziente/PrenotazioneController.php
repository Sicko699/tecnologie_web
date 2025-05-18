<?php

namespace App\Http\Controllers\Paziente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Richiesta;
use App\Models\Prestazione;
use Illuminate\Support\Facades\Auth;

class PrenotazioneController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view("paziente.dashboard");
    }

    // Lista prenotazioni proprie
    public function index()
    {
        $prenotazioni = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->with('prestazione.dipartimento')->get();
        return view('paziente.prenotazioni.index', compact('prenotazioni'));
    }

    // Mostra dettaglio prenotazione
    public function show($id)
    {
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->with('prestazione.dipartimento')->findOrFail($id);
        return view('paziente.prenotazioni.show', compact('prenotazione'));
    }

    // Form nuova prenotazione
    public function create()
    {
        $prestazioni = Prestazione::with('dipartimento')->get();
        return view('paziente.prenotazioni.create', compact('prestazioni'));
    }

    // Salva nuova prenotazione
    public function store(Request $request)
    {
        $request->validate([
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'data_richiesta' => 'required|date',
            'giorno_escluso' => 'nullable|string|max:100'
        ]);
        Richiesta::create([
            'id_utente' => Auth::user()->codice_fiscale,
            'id_prestazione' => $request->id_prestazione,
            'data_richiesta' => $request->data_richiesta,
            'giorno_escluso' => $request->giorno_escluso,
            'stato' => 'in attesa'
        ]);
        return redirect()->route('paziente.prenotazioni.index')->with('success', 'Prenotazione creata!');
    }

    // Form modifica prenotazione
    public function edit($id)
    {
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->findOrFail($id);
        return view('paziente.prenotazioni.edit', compact('prenotazione'));
    }

    // Aggiorna prenotazione
    public function update(Request $request, $id)
    {
        $request->validate([
            'data_richiesta' => 'required|date',
            'giorno_escluso' => 'nullable|string|max:100'
        ]);
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->findOrFail($id);
        $prenotazione->update($request->only('data_richiesta', 'giorno_escluso'));
        return redirect()->route('paziente.prenotazioni.index')->with('success', 'Prenotazione aggiornata!');
    }

    // Elimina prenotazione
    public function destroy($id)
    {
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->findOrFail($id);
        $prenotazione->delete();
        return redirect()->route('paziente.prenotazioni.index')->with('success', 'Prenotazione eliminata!');
    }
}
