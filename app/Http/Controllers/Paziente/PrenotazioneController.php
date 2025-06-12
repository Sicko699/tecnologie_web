<?php

namespace App\Http\Controllers\Paziente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Richiesta;
use App\Models\Prestazione;
use Illuminate\Support\Facades\Auth;

class PrenotazioneController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $notifiche = $user->notifiche()
            ->orderByDesc('data_creazione')
            ->take(5)
            ->get();

        $prenotazioni = $user->richieste()
            ->orderByDesc('id_richiesta')
            ->take(5)
            ->get();

        return view('paziente.dashboard', compact('notifiche', 'prenotazioni'));
    }

    public function index()
    {
        $prenotazioni = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->with('prestazione.dipartimento')->get();
        return view('paziente.prenotazioni.index', compact('prenotazioni'));
    }

    public function show($id)
    {
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->with('prestazione.dipartimento')->findOrFail($id);
        return view('paziente.prenotazioni.show', compact('prenotazione'));
    }

    public function create()
    {
        $prestazioni = Prestazione::with('dipartimento')->get();
        return view('paziente.prenotazioni.create', compact('prestazioni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'giorno_escluso' => 'nullable|string|max:100'
        ]);

        $prestazione = Prestazione::findOrFail($request->id_prestazione);

        Richiesta::create([
            'id_utente' => Auth::user()->codice_fiscale,
            'id_prestazione' => $request->id_prestazione,
            'giorno_escluso' => $request->giorno_escluso,
            'stato' => 'in attesa',
            'id_dipartimento' => $prestazione->id_dipartimento
        ]);
        return redirect()->route('paziente.prenotazioni.index')->with('success', 'Prenotazione creata!');
    }

    public function edit($id)
    {
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->findOrFail($id);
        $giorno_escluso = $prenotazione->giorno_escluso;
        //dd($giorno_escluso);
        return view('paziente.prenotazioni.edit', compact('prenotazione', 'giorno_escluso'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'giorno_escluso' => 'nullable|string|max:100'
        ]);
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->findOrFail($id);
        $prenotazione->update([
            'giorno_escluso' => $request->giorno_escluso,
            'stato' => 'in attesa'
        ]);
        return redirect()->route('paziente.prenotazioni.index')->with('success', 'Prenotazione aggiornata!');
    }

    public function destroy($id)
    {
        $prenotazione = Richiesta::where('id_utente', Auth::user()->codice_fiscale)->findOrFail($id);
        $prenotazione->delete();
        return redirect()->route('paziente.prenotazioni.index')->with('success', 'Prenotazione eliminata!');
    }
}
