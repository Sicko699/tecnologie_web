<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UtenteController extends Controller
{
    public function index()
    {
        $utenti = User::all();
        return view('admin.utenti.index', compact('utenti'));
    }

    public function create()
    {
        return view('admin.utenti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codice_fiscale' => 'required|string|max:16|unique:users,codice_fiscale',
            'nome' => 'required|string|max:100',
            'cognome' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:50',
            'data_nascita' => 'nullable|date',
            'ruolo' => 'required|string|in:paziente,staff,admin'
        ]);
        User::create([
            'codice_fiscale' => $request->codice_fiscale,
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telefono' => $request->telefono,
            'data_nascita' => $request->data_nascita,
            'ruolo' => $request->ruolo
        ]);
        return redirect()->route('admin.utenti.index')->with('success', 'Utente creato!');
    }

    public function show($id)
    {
        $utente = User::findOrFail($id);
        return view('admin.utenti.show', compact('utente'));
    }

    public function edit($id)
    {
        $utente = User::findOrFail($id);
        return view('admin.utenti.edit', compact('utente'));
    }

    public function update(Request $request, $id)
    {
        $utente = User::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:100',
            'cognome' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,'.$utente->codice_fiscale.',codice_fiscale',
            'telefono' => 'nullable|string|max:50',
            'data_nascita' => 'nullable|date',
            'ruolo' => 'required|string|in:paziente,staff,admin'
        ]);
        $utente->update($request->only('nome', 'cognome', 'email', 'telefono', 'data_nascita', 'ruolo'));
        return redirect()->route('admin.utenti.index')->with('success', 'Utente aggiornato!');
    }

    public function destroy($id)
    {
        $utente = User::findOrFail($id);
        $utente->delete();
        return redirect()->route('admin.utenti.index')->with('success', 'Utente eliminato!');
    }
}
