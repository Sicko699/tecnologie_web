<?php

namespace App\Http\Controllers;

use App\Models\Richiesta;
use App\Models\User;
use App\Models\Prestazione;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RichiestaController extends Controller
{
    public function index()
    {
        $richieste = Richiesta::with(['utente', 'prestazione'])->get();
        return view('richieste.index', compact('richieste'));
    }

    public function create()
    {
        $utenti = User::all();
        $prestazioni = Prestazione::all();
        return view('richieste.create', compact('utenti', 'prestazioni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_utente' => 'required|exists:users,codice_fiscale',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'data_richiesta' => 'required|date',
            'giorno_escluso' => 'nullable|date',
            'stato' => 'required|string|max:50'
        ]);
        Richiesta::create($request->all());
        return redirect()->route('richieste.index')->with('success', 'Richiesta creata!');
    }

    public function show($id)
    {
        $richiesta = Richiesta::with(['utente', 'prestazione'])->findOrFail($id);
        return view('richieste.show', compact('richiesta'));
    }

    public function edit($id)
    {
        $richiesta = Richiesta::findOrFail($id);
        $utenti = User::all();
        $prestazioni = Prestazione::all();
        return view('richieste.edit', compact('richiesta', 'utenti', 'prestazioni'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_utente' => 'required|exists:users,codice_fiscale',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'data_richiesta' => 'required|date',
            'giorno_escluso' => 'nullable|date',
            'stato' => 'required|string|max:50'
        ]);
        $richiesta = Richiesta::findOrFail($id);
        $richiesta->update($request->all());
        return redirect()->route('richieste.index')->with('success', 'Richiesta aggiornata!');
    }

    public function destroy($id)
    {
        $richiesta = Richiesta::findOrFail($id);
        $richiesta->delete();
        return redirect()->route('richieste.index')->with('success', 'Richiesta eliminata!');
    }

    public function publicStore(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'reparto' => 'required|string|max:255',
            'data' => 'required|string', // string perché viene convertita manualmente
            'ora' => 'required|string|max:10',
        ]);

        // Conversione data da 'd/m/Y' a 'Y-m-d'
        $dataConvertita = Carbon::createFromFormat('d/m/Y', $request->data)->format('Y-m-d');

        Richiesta::create([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'reparto' => $request->reparto,
            'data_richiesta' => $dataConvertita,
            'ora' => $request->ora,
            'stato' => 'in attesa'
        ]);

        return redirect()->back()->with('success', 'Richiesta inviata con successo!');
    }
}
