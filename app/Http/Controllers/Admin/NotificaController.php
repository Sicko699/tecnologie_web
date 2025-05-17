<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifica;
use App\Models\User;

class NotificaController extends Controller
{
    // Mostra tutte le notifiche inviate
    public function index()
    {
        $notifiche = Notifica::with('utente')->orderByDesc('data_creazione')->get();
        $utenti = User::all(); // Per eventuale invio da interfaccia
        return view('admin.notifiche.index', compact('notifiche', 'utenti'));
    }

    // Invio nuova notifica
    public function store(Request $request)
    {
        $request->validate([
            'id_utente' => 'required|exists:users,codice_fiscale',
            'messaggio' => 'required|string|max:255'
        ]);
        Notifica::create([
            'id_utente' => $request->id_utente,
            'messaggio' => $request->messaggio,
            'data_creazione' => now(),
            'conferma_lettura' => false
        ]);
        return redirect()->route('admin.notifiche.index')->with('success', 'Notifica inviata!');
    }

    // Elimina una notifica
    public function destroy($id)
    {
        $notifica = Notifica::findOrFail($id);
        $notifica->delete();
        return redirect()->route('admin.notifiche.index')->with('success', 'Notifica eliminata!');
    }
}
