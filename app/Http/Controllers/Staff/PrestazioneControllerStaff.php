<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Support\Facades\Auth;

class PrestazioneControllerStaff extends Controller
{
    // Lista prestazioni gestite dallo staff attuale
    public function index()
    {
        $cf = Auth::user()->codice_fiscale;
        $prestazioni = Prestazione::where('id_membro', $cf)->with('dipartimento')->get();
        return view('staff.prestazioni.index', compact('prestazioni'));
    }

    // Form creazione prestazione
    public function create()
    {
        $dipartimenti = Dipartimento::all();
        return view('staff.prestazioni.create', compact('dipartimenti'));
    }

    // Salva nuova prestazione
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
        ]);
        Prestazione::create([
            'nome' => $request->nome,
            'descrizione' => $request->descrizione,
            'id_dipartimento' => $request->id_dipartimento,
            'id_membro' => Auth::user()->codice_fiscale
        ]);
        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione creata!');
    }

    // Form modifica prestazione
    public function edit($id)
    {
        $cf = Auth::user()->codice_fiscale;
        $prestazione = Prestazione::where('id_membro', $cf)->findOrFail($id);
        $dipartimenti = Dipartimento::all();
        return view('staff.prestazioni.edit', compact('prestazione', 'dipartimenti'));
    }

    // Aggiorna prestazione
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
        ]);
        $cf = Auth::user()->codice_fiscale;
        $prestazione = Prestazione::where('id_membro', $cf)->findOrFail($id);
        $prestazione->update($request->only('nome', 'descrizione', 'id_dipartimento'));
        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione aggiornata!');
    }

    // Elimina prestazione
    public function destroy($id)
    {
        $cf = Auth::user()->codice_fiscale;
        $prestazione = Prestazione::where('id_membro', $cf)->findOrFail($id);
        $prestazione->delete();
        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione eliminata!');
    }
}
