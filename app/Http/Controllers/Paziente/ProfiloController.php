<?php

namespace App\Http\Controllers\Paziente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ProfiloController extends Controller
{
    public function show()
    {
        return view('paziente.profilo');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ATTENZIONE: modifica qui se la tua PK non è 'id'
        $primaryKey = 'id';
        if (array_key_exists('codice_fiscale', $user->getAttributes())) {
            $primaryKey = 'codice_fiscale';
        }

        $request->validate([
            'nome' => 'required|string|max:100',
            'cognome' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $user->$primaryKey . ',' . $primaryKey,
            'telefono' => 'nullable|string|max:50',

            // Regole per cambio password (solo se password viene compilata)
            'current_password' => 'required_with:password',
            'password' => [
                'nullable',
                'confirmed',
                PasswordRule::min(8),
            ],
        ], [
            'current_password.required_with' => 'Inserisci la vecchia password per modificarla.',
            'password.confirmed' => 'La conferma password non corrisponde.',
        ]);

        // AGGIORNA DATI PROFILO
        $user->nome = $request->nome;
        $user->cognome = $request->cognome;
        $user->email = $request->email;
        $user->telefono = $request->telefono;

        // CAMBIO PASSWORD (solo se richiesto)
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La vecchia password non è corretta.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('paziente.dashboard')->with('success', 'Profilo aggiornato!');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success', 'Account eliminato.');
    }
}
