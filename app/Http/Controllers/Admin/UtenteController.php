<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dipartimento;
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
        $utenti = User::where('ruolo', 'staff')
            ->with('membroStaff.dipartimento')
            ->get();

        return view('admin.utenti.index', compact('utenti'));
    }



    public function create()
    {
        $dipartimenti = Dipartimento::all();
        return view('admin.utenti.create', compact('dipartimenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'           => ['required', 'string', 'max:100'],
            'cognome'        => ['required', 'string', 'max:100'],
            'username'       => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
            'id_dipartimento'=> ['required', 'exists:dipartimenti,id_dipartimento'],
        ]);

        $codice_fiscale = strtoupper(substr(uniqid(md5($request->nome . $request->cognome)), 0, 16));

        $user = User::create([
            'codice_fiscale' => $codice_fiscale,
            'nome'           => $request->nome,
            'cognome'        => $request->cognome,
            'username'       => $request->username,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'ruolo'          => 'staff',
        ]);

        $membroStaff = MembroStaff::create([
            'codice_fiscale'  => $user->codice_fiscale,
            'id_dipartimento' => $request->id_dipartimento,
        ]);

        $prestazioni = \App\Models\Prestazione::where('id_dipartimento', $membroStaff->id_dipartimento)->get();
        $membroStaff->prestazioni()->syncWithoutDetaching($prestazioni->pluck('id_prestazione'));

        return redirect()->route('admin.utenti.index')->with('success', 'Staff creato con successo.');
    }

    public function edit($codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);
        $dipartimenti = Dipartimento::all();
        return view('admin.utenti.edit', compact('utente', 'dipartimenti'));
    }

    public function update(Request $request, $codice_fiscale)
    {
        $utente = User::with('membroStaff')->findOrFail($codice_fiscale);

        $request->validate([
            'nome'             => 'required|string|max:100',
            'cognome'          => 'required|string|max:100',
            'username'         => 'required|string|max:50|unique:users,username,' . $utente->codice_fiscale . ',codice_fiscale',
            'id_dipartimento'  => 'required|exists:dipartimenti,id_dipartimento',
        ]);

        $utente->update([
            'nome'     => $request->nome,
            'cognome'  => $request->cognome,
            'username' => $request->username,
        ]);

        // ✅ Se esiste, aggiorna. Se non esiste, crea.
        if ($utente->membroStaff) {
            $utente->membroStaff->update([
                'id_dipartimento' => $request->id_dipartimento,
            ]);
        } else {
            $utente->membroStaff()->create([
                'id_dipartimento' => $request->id_dipartimento,
            ]);
        }

        // Controllo finale
        $utente->load('membroStaff.dipartimento');
        return redirect()->route('admin.utenti.index')->with('success', 'Utente aggiornato correttamente.');
    }

    public function destroy($codice_fiscale)
    {
        $utente = User::findOrFail($codice_fiscale);
        if ($utente->membroStaff) {
            $utente->membroStaff->delete();
        }
        $utente->delete();
        return redirect()->route('admin.utenti.index')->with('success', 'Utente eliminato!');
    }
}
