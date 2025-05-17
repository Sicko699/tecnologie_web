<?php

namespace App\Http\Controllers;

use App\Models\Amministratore;
use App\Models\User;
use Illuminate\Http\Request;

class AmministratoreController extends Controller
{
    public function index()
    {
        $amministratori = Amministratore::with('user')->get();
        return view('amministratori.index', compact('amministratori'));
    }

    public function create()
    {
        $utenti = User::all();
        return view('amministratori.create', compact('utenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codice_fiscale' => 'required|exists:users,codice_fiscale'
        ]);
        Amministratore::create($request->all());
        return redirect()->route('amministratori.index')->with('success', 'Amministratore aggiunto!');
    }

    public function show($codice_fiscale)
    {
        $amministratore = Amministratore::with('user')->findOrFail($codice_fiscale);
        return view('amministratori.show', compact('amministratore'));
    }

    public function edit($codice_fiscale)
    {
        $amministratore = Amministratore::findOrFail($codice_fiscale);
        $utenti = User::all();
        return view('amministratori.edit', compact('amministratore', 'utenti'));
    }

    public function update(Request $request, $codice_fiscale)
    {
        $amministratore = Amministratore::findOrFail($codice_fiscale);
        // Qui puoi aggiornare solo eventuali dati collegati, se servono
        return redirect()->route('amministratori.index')->with('success', 'Amministratore aggiornato!');
    }

    public function destroy($codice_fiscale)
    {
        $amministratore = Amministratore::findOrFail($codice_fiscale);
        $amministratore->delete();
        return redirect()->route('amministratori.index')->with('success', 'Amministratore eliminato!');
    }
}
