<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statistica;

class StatisticaController extends Controller
{
    // Lista di tutte le statistiche
    public function index()
    {
        $statistiche = Statistica::with('prestazione.dipartimento', 'amministratore')->get();
        return view('admin.statistiche.index', compact('statistiche'));
    }

    // Dettaglio singola statistica
    public function show($id)
    {
        $statistica = Statistica::with('prestazione.dipartimento', 'amministratore')->findOrFail($id);
        return view('admin.statistiche.show', compact('statistica'));
    }
}
