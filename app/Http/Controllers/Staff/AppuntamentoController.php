<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appuntamento;
use Illuminate\Support\Facades\Auth;

class AppuntamentoController extends Controller
{
    // Mostra tutti gli appuntamenti assegnati a questo membro dello staff
    public function index()
    {
        $cf = Auth::user()->codice_fiscale;
        $appuntamenti = Appuntamento::whereHas('richiesta.prestazione', function($q) use ($cf) {
            $q->where('id_membro', $cf);
        })->with('richiesta.utente', 'richiesta.prestazione.dipartimento')->get();

        return view('staff.appuntamenti.index', compact('appuntamenti'));
    }

    // Form per modificare un appuntamento
    public function edit($id)
    {
        $appuntamento = Appuntamento::with('richiesta.utente', 'richiesta.prestazione.dipartimento')->findOrFail($id);
        return view('staff.appuntamenti.edit', compact('appuntamento'));
    }

    // Aggiorna appuntamento
    public function update(Request $request, $id)
    {
        $request->validate([
            'data' => 'required|date',
            'ora' => 'required',
            'stato' => 'required|string|max:30'
        ]);
        $appuntamento = Appuntamento::findOrFail($id);
        $appuntamento->update($request->only('data', 'ora', 'stato'));
        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento aggiornato!');
    }

    // Elimina appuntamento
    public function destroy($id)
    {
        $appuntamento = Appuntamento::findOrFail($id);
        $appuntamento->delete();
        return redirect()->route('staff.appuntamenti.index')->with('success', 'Appuntamento eliminato!');
    }
}
