<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'codice_fiscale' => ['required', 'string', 'size:16', 'unique:users,codice_fiscale'],
            'nome'           => ['required', 'string', 'max:100'],
            'cognome'        => ['required', 'string', 'max:100'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telefono'       => ['nullable', 'string', 'max:50'],
            'data_nascita'   => ['nullable', 'date'],
            'foto'           => ['nullable', 'image', 'max:2048'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Gestione upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profili', 'public');
        }

        $user = User::create([
            'codice_fiscale' => strtoupper($request->codice_fiscale),
            'nome'           => $request->nome,
            'cognome'        => $request->cognome,
            'email'          => $request->email,
            'telefono'       => $request->telefono,
            'data_nascita'   => $request->data_nascita,
            'foto'           => $fotoPath,
            'user'           => $request->ruolo, // correggi questa linea nel create
            'password'       => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('admin.utenti.index')->with('success', 'Utente registrato con successo.');
    }


    public function edit($codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);
        return view('admin.utenti.edit', compact('utente'));
    }

    public function update(Request $request, $codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);

        $request->validate([
            'nome'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $utente->codice_fiscale . ',codice_fiscale',
            'ruolo' => 'required|in:admin,staff',
        ]);


        $utente->update([
            'nome' => $request->nome,
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
