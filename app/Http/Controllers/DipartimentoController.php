<?php

namespace App\Http\Controllers;

use App\Models\Dipartimento;
use Illuminate\Http\Request;

class DipartimentoController extends Controller
{
    public function index()
    {
        // Recupera tutti i dipartimenti per mostrarli nella pagina trattamenti
        $dipartimenti = Dipartimento::all();
        return view('department', compact('dipartimenti'));
    }

    public function create()
    {
        // Pagina per creare un nuovo dipartimento (solo admin)
        return view('dipartimenti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'descrizione' => 'nullable|string'
        ]);
        Dipartimento::create($request->all());
        return redirect()->route('department.index')->with('success', 'Dipartimento creato!');
    }

    public function show($id)
    {
        $dipartimento = Dipartimento::findOrFail($id);
        return view('dipartimenti.show', compact('dipartimento'));
    }

    public function edit($id)
    {
        $dipartimento = Dipartimento::findOrFail($id);
        return view('dipartimenti.edit', compact('dipartimento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'descrizione' => 'nullable|string'
        ]);
        $dipartimento = Dipartimento::findOrFail($id);
        $dipartimento->update($request->all());
        return redirect()->route('department.index')->with('success', 'Dipartimento aggiornato!');
    }

    public function destroy($id)
    {
        $dipartimento = Dipartimento::findOrFail($id);
        $dipartimento->delete();
        return redirect()->route('department.index')->with('success', 'Dipartimento eliminato!');
    }
}
