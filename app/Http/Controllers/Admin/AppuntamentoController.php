<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appuntamento;
use App\Models\Richiesta;

class AppuntamentoController extends Controller
{
    public function index()
    {
        $appuntamenti = Appuntamento::with('richiesta.prestazione', 'richiesta.utente')->get();
        return view('admin.appuntamenti.index', compact('appuntamenti'));
    }

    public function create()
    {
        $richieste = Richiesta::with('prestazione', 'utente')->get();
        return view('admin.appuntamenti.create', compact('richieste'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date',
            'ora' => 'required',
            'stato' => 'required|string|max:30'
        ]);
        Appuntamento::create($request->only('id_richiesta', 'data', 'ora', 'stato'));
        return redirect()->route('admin.appuntamenti.index')->with('success', 'Appuntamento creato!');
    }

    public function show($id)
    {
        $appuntamento = Appuntamento::with('richiesta.prestazione', 'richiesta.utente')->findOrFail($id);
        return view('admin.appuntamenti.show', compact('appuntamento'));
    }

    public function edit($id)
    {
        $appuntamento = Appuntamento::findOrFail($id);
        $richieste = Richiesta::with('prestazione', 'utente')->get();
        return view('admin.appuntamenti.edit', compact('appuntamento', 'richieste'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_richiesta' => 'required|exists:richieste,id_richiesta',
            'data' => 'required|date',
            'ora' => 'required',
            'stato' => 'required|string|max:30'
        ]);
        $appuntamento = Appuntamento::findOrFail($id);
        $appuntamento->update($request->only('id_richiesta', 'data', 'ora', 'stato'));
        return redirect()->route('admin.appuntamenti.index')->with('success', 'Appuntamento aggiornato!');
    }

    public function destroy($id)
    {
        $appuntamento = Appuntamento::findOrFail($id);
        $appuntamento->delete();
        return redirect()->route('admin.appuntamenti.index')->with('success', 'Appuntamento eliminato!');
    }
}
