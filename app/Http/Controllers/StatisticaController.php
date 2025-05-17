<?php

namespace App\Http\Controllers;

use App\Models\Statistica;
use App\Models\Prestazione;
use App\Models\Amministratore;
use Illuminate\Http\Request;

class StatisticaController extends Controller
{
    public function index()
    {
        $statistiche = Statistica::with(['amministratore', 'prestazione'])->get();
        return view('statistiche.index', compact('statistiche'));
    }

    public function create()
    {
        $amministratori = Amministratore::all();
        $prestazioni = Prestazione::all();
        return view('statistiche.create', compact('amministratori', 'prestazioni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_amministratore' => 'required|exists:amministratori,codice_fiscale',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date|after_or_equal:data_inizio',
            'tipo' => 'required|string|max:100',
            'risultato' => 'required'
        ]);
        Statistica::create($request->all());
        return redirect()->route('statistiche.index')->with('success', 'Statistica creata!');
    }

    public function show($id)
    {
        $statistica = Statistica::with(['amministratore', 'prestazione'])->findOrFail($id);
        return view('statistiche.show', compact('statistica'));
    }

    public function edit($id)
    {
        $statistica = Statistica::findOrFail($id);
        $amministratori = Amministratore::all();
        $prestazioni = Prestazione::all();
        return view('statistiche.edit', compact('statistica', 'amministratori', 'prestazioni'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_amministratore' => 'required|exists:amministratori,codice_fiscale',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date|after_or_equal:data_inizio',
            'tipo' => 'required|string|max:100',
            'risultato' => 'required'
        ]);
        $statistica = Statistica::findOrFail($id);
        $statistica->update($request->all());
        return redirect()->route('statistiche.index')->with('success', 'Statistica aggiornata!');
    }

    public function destroy($id)
    {
        $statistica = Statistica::findOrFail($id);
        $statistica->delete();
        return redirect()->route('statistiche.index')->with('success', 'Statistica eliminata!');
    }
}
