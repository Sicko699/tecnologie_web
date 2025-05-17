<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Prestazione;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agende = Agenda::with('prestazione')->get();
        return view('agende.index', compact('agende'));
    }

    public function create()
    {
        $prestazioni = Prestazione::all();
        return view('agende.create', compact('prestazioni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'giorno_settimana' => 'required|string|max:20',
            'slot_orario' => 'required|string|max:20',
            'max_appuntamenti' => 'required|integer|min:1'
        ]);
        Agenda::create($request->all());
        return redirect()->route('agende.index')->with('success', 'Slot agenda creato!');
    }

    public function show($id)
    {
        $agenda = Agenda::with('prestazione')->findOrFail($id);
        return view('agende.show', compact('agenda'));
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $prestazioni = Prestazione::all();
        return view('agende.edit', compact('agenda', 'prestazioni'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'giorno_settimana' => 'required|string|max:20',
            'slot_orario' => 'required|string|max:20',
            'max_appuntamenti' => 'required|integer|min:1'
        ]);
        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());
        return redirect()->route('agende.index')->with('success', 'Slot agenda aggiornato!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('agende.index')->with('success', 'Slot agenda eliminato!');
    }
}
