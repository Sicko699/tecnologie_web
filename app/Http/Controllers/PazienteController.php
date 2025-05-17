<?php

namespace App\Http\Controllers;

use App\Models\Paziente;
use App\Models\User;
use Illuminate\Http\Request;

class PazienteController extends Controller
{
    public function index()
    {
        $pazienti = Paziente::with('user')->get();
        return view('pazienti.index', compact('pazienti'));
    }

    public function create()
    {
        $utenti = User::all();
        return view('pazienti.create', compact('utenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codice_fiscale' => 'required|exists:users,codice_fiscale'
        ]);
        Paziente::create($request->all());
        return redirect()->route('pazienti.index')->with('success', 'Paziente aggiunto!');
    }

    public function show($codice_fiscale)
    {
        $paziente = Paziente::with('user')->findOrFail($codice_fiscale);
        return view('pazienti.show', compact('paziente'));
    }

    public function edit($codice_fiscale)
    {
        $paziente = Paziente::findOrFail($codice_fiscale);
        $utenti = User::all();
        return view('pazienti.edit', compact('paziente', 'utenti'));
    }

    public function update(Request $request, $codice_fiscale)
    {
        $paziente = Paziente::findOrFail($codice_fiscale);
        // Qui puoi aggiornare solo eventuali dati collegati, se servono
        return redirect()->route('pazienti.index')->with('success', 'Paziente aggiornato!');
    }

    public function destroy($codice_fiscale)
    {
        $paziente = Paziente::findOrFail($codice_fiscale);
        $paziente->delete();
        return redirect()->route('pazienti.index')->with('success', 'Paziente eliminato!');
    }
}
