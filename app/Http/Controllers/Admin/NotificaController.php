<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifica;
use App\Models\User;

class NotificaController extends Controller
{
    public function index()
    {
        $notifiche = Notifica::with('utente')->orderByDesc('data_creazione')->get();
        $utenti = User::all();
        return view('admin.notifiche.index', compact('notifiche', 'utenti'));
    }

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
    public function destroy($id)
    {
        $notifica = Notifica::findOrFail($id);
        $notifica->delete();
        return redirect()->route('admin.notifiche.index')->with('success', 'Notifica eliminata!');
    }
}
