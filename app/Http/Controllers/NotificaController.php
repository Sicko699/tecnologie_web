<?php

namespace App\Http\Controllers;

use App\Models\Notifica;
use App\Models\User;
use Illuminate\Http\Request;

class NotificaController extends Controller
{
    public function index()
    {
        $notifiche = Notifica::with('user')->get();
        return view('notifiche.index', compact('notifiche'));
    }

    public function create()
    {
        $utenti = User::all();
        return view('notifiche.create', compact('utenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_utente' => 'required|exists:users,codice_fiscale',
            'messaggio' => 'required|string',
            'data_creazione' => 'required|date',
            'conferma_lettura' => 'boolean'
        ]);
        Notifica::create($request->all());
        return redirect()->route('notifiche.index')->with('success', 'Notifica creata!');
    }

    public function show($id)
    {
        $notifica = Notifica::with('user')->findOrFail($id);
        return view('notifiche.show', compact('notifica'));
    }

    public function edit($id)
    {
        $notifica = Notifica::findOrFail($id);
        $utenti = User::all();
        return view('notifiche.edit', compact('notifica', 'utenti'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_utente' => 'required|exists:users,codice_fiscale',
            'messaggio' => 'required|string',
            'data_creazione' => 'required|date',
            'conferma_lettura' => 'boolean'
        ]);
        $notifica = Notifica::findOrFail($id);
        $notifica->update($request->all());
        return redirect()->route('notifiche.index')->with('success', 'Notifica aggiornata!');
    }

    public function destroy($id)
    {
        $notifica = Notifica::findOrFail($id);
        $notifica->delete();
        return redirect()->route('notifiche.index')->with('success', 'Notifica eliminata!');
    }
}
