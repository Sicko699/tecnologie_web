<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MembroStaff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UtenteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $utenti = User::with(['membroStaff.dipartimento'])
            ->where('ruolo', 'staff')
            ->get();
        return view('admin.utenti.index', compact('utenti'));
    }

    public function create()
    {
        // Recupera tutti i dipartimenti per la select
        $dipartimenti = \App\Models\Dipartimento::all();
        return view('admin.utenti.create', compact('dipartimenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'           => ['required', 'string', 'max:100'],
            'cognome'        => ['required', 'string', 'max:100'],
            'username'       => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'id_dipartimento'=> ['required', 'exists:dipartimenti,id_dipartimento'],
        ]);

        // Genera un codice fiscale fittizio univoco se non lo inserisci, o genera a partire da nome/cognome
        // Qui creiamo una stringa random di 16 caratteri (ma puoi sostituire con la logica che vuoi tu)
        $codice_fiscale = strtoupper(substr(uniqid(md5($request->nome . $request->cognome)), 0, 16));
        // oppure puoi chiedere di inserirlo tramite la form, ma ora lo generiamo per esempio.

        // CREA L'UTENTE STAFF
        $user = User::create([
            'codice_fiscale' => $codice_fiscale,
            'nome'           => $request->nome,
            'cognome'        => $request->cognome,
            'username'       => $request->username,
            'password'       => Hash::make($request->password),
            'ruolo'          => 'staff',
        ]);

        // CREA IL MEMBRO STAFF ASSOCIATO
        $membroStaff = MembroStaff::create([
            'codice_fiscale'  => $user->codice_fiscale,
            'id_dipartimento' => $request->id_dipartimento,
        ]);

        return redirect()->route('admin.utenti.index')->with('success', 'Staff creato con successo.');
    }

    public function edit($codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);
        $dipartimenti = \App\Models\Dipartimento::all();
        return view('admin.utenti.edit', compact('utente', 'dipartimenti'));
    }

    public function update(Request $request, $codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);

        $request->validate([
            'nome'     => 'required|string|max:100',
            'cognome'  => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $utente->codice_fiscale . ',codice_fiscale',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'password' => 'nullable|confirmed', // opzionale, solo se vuoi cambiare password
        ]);

        $utente->nome = $request->nome;
        $utente->cognome = $request->cognome;
        $utente->username = $request->username;
        // aggiorna password solo se compilata
        if($request->filled('password')) {
            $utente->password = Hash::make($request->password);
        }
        $utente->save();

        // aggiorna dipartimento in membro_staff
        if ($utente->membroStaff) {
            $utente->membroStaff->id_dipartimento = $request->id_dipartimento;
            $utente->membroStaff->save();
        }

        return redirect()->route('admin.utenti.index')->with('success', 'Utente aggiornato!');
    }

    public function destroy($codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);
        // cancella anche membro_staff associato
        if ($utente->membroStaff) {
            $utente->membroStaff->delete();
        }
        $utente->delete();
        return redirect()->route('admin.utenti.index')->with('success', 'Utente eliminato!');
    }
}
