<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class PrestazioneController extends Controller
{
    public function index()
    {
        $prestazioni = Prestazione::with('dipartimento')->get();
        return view('prestazioni.index', compact('prestazioni'));
    }

    public function create()
    {
        $dipartimenti = Dipartimento::all();
        return view('prestazioni.create', compact('dipartimenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'descrizione' => 'nullable|string',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'id_membro' => 'nullable|exists:membro_staff,codice_fiscale'
        ]);
        Prestazione::create($request->all());
        return redirect()->route('prestazioni.index')->with('success', 'Prestazione creata!');
    }

    public function show($id)
    {
        $prestazione = Prestazione::with('dipartimento')->findOrFail($id);
        return view('prestazioni.show', compact('prestazione'));
    }

    public function edit($id)
    {
        $prestazione = Prestazione::findOrFail($id);
        $dipartimenti = Dipartimento::all();
        return view('prestazioni.edit', compact('prestazione', 'dipartimenti'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'descrizione' => 'nullable|string',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'id_membro' => 'nullable|exists:membro_staff,codice_fiscale'
        ]);
        $prestazione = Prestazione::findOrFail($id);
        $prestazione->update($request->all());
        return redirect()->route('prestazioni.index')->with('success', 'Prestazione aggiornata!');
    }

    public function destroy($id)
    {
        $prestazione = Prestazione::findOrFail($id);
        $prestazione->delete();
        return redirect()->route('prestazioni.index')->with('success', 'Prestazione eliminata!');
    }
}
