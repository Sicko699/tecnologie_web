<?php

namespace App\Http\Controllers\Paziente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfiloController extends Controller
{
    public function show()
    {
        return view('paziente.profilo');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nome' => 'required|string|max:100',
            'cognome' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $user->codice_fiscale . ',codice_fiscale',
            'telefono' => 'nullable|string|max:50'
        ]);
        $user->update($request->only('nome', 'cognome', 'email', 'telefono'));
        return redirect()->route('paziente.profilo')->with('success', 'Profilo aggiornato!');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success', 'Account eliminato.');
    }
}
