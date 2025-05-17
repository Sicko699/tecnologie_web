<?php

namespace App\Http\Controllers\Paziente;

use App\Http\Controllers\Controller;
use App\Models\Appuntamento;
use Illuminate\Support\Facades\Auth;

class AppuntamentoController extends Controller
{
    public function index()
    {
        // Trova appuntamenti tramite le richieste dell'utente loggato
        $user_cf = Auth::user()->codice_fiscale;
        $appuntamenti = Appuntamento::whereHas('richiesta', function($q) use ($user_cf) {
            $q->where('id_utente', $user_cf);
        })->with('richiesta.prestazione')->get();
        return view('paziente.appuntamenti.index', compact('appuntamenti'));
    }
}
