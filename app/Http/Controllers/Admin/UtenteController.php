<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UtenteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $utenti = User::whereIn('ruolo', ['admin', 'staff'])->get();
        return view('admin.utenti.index', compact('utenti'));
    }

    public function create()
    {
        return view('admin.utenti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'ruolo' => 'required|in:admin,staff',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'ruolo' => $request->ruolo,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.utenti.index')->with('success', 'Utente creato!');
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $utente->id,
            'ruolo' => 'required|in:admin,staff',
        ]);

        $utente->update([
            'name' => $request->name,
            'email' => $request->email,
            'ruolo' => $request->ruolo,
        ]);

        return redirect()->route('admin.utenti.index')->with('success', 'Utente aggiornato!');
    }

    public function destroy($id)
    {
        $utente = User::findOrFail($id);
        $utente->delete();
        return redirect()->route('admin.utenti.index')->with('success', 'Utente eliminato!');
    }
}
