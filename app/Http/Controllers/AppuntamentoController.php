<?php

namespace App\Http\Controllers;

use App\Models\Appuntamento;
use App\Models\Richiesta;
use Illuminate\Http\Request;

class AppuntamentoController extends Controller
{
    public function index()
    {
        $appuntamenti = Appuntamento::with('richiesta')->get();
        return view('appuntamenti.index', compact('appuntamenti'));
    }

    public function create()
    {
        $richieste = Richiesta::all();
        return view('appuntamenti.create', compact('richieste'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date',
            'ora' => 'required',
            'stato' => 'required|string|max:50'
        ]);
        Appuntamento::create($request->all());
        return redirect()->route('appuntamenti.index')->with('success', 'Appuntamento creato!');
    }

    public function show($id)
    {
        $appuntamento = Appuntamento::with('richiesta')->findOrFail($id);
        return view('appuntamenti.show', compact('appuntamento'));
    }

    public function edit($id)
    {
        $appuntamento = Appuntamento::findOrFail($id);
        $richieste = Richiesta::all();
        return view('appuntamenti.edit', compact('appuntamento', 'richieste'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date',
            'ora' => 'required',
            'stato' => 'required|string|max:50'
        ]);
        $appuntamento = Appuntamento::findOrFail($id);
        $appuntamento->update($request->all());
        return redirect()->route('appuntamenti.index')->with('success', 'Appuntamento aggiornato!');
    }

    public function destroy($id)
    {
        $appuntamento = Appuntamento::findOrFail($id);
        $appuntamento->delete();
        return redirect()->route('appuntamenti.index')->with('success', 'Appuntamento eliminato!');
    }
}
