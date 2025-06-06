<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembroStaff;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class PrestazioneController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $prestazioni = Prestazione::with('dipartimento')->get();
        return view('admin.prestazioni.index', compact('prestazioni'));
    }

    public function create()
    {
        $dipartimenti = Dipartimento::all();
        return view('admin.prestazioni.create', compact('dipartimenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'descrizione' => 'required|string|max:255',
        ]);

        // 1. Crea la prestazione
        $prestazione = Prestazione::create([
            'nome' => $request->nome,
            'id_dipartimento' => $request->id_dipartimento,
            'descrizione' => $request->descrizione,
        ]);

        // 2. Trova tutti i membri staff del dipartimento scelto
        $membri = \App\Models\MembroStaff::where('id_dipartimento', $request->id_dipartimento)->get();

        // 3. Associa la prestazione a questi membri staff tramite la tabella pivot
        $prestazione->membriStaff()->sync($membri->pluck('codice_fiscale'));

        // 4. Redirect (come già fai)
        return redirect()->route('admin.agende.create', [
            'id_dipartimento' => $prestazione->id_dipartimento,
            'id_prestazione' => $prestazione->id_prestazione,
            'descrizione' => $prestazione->descrizione
        ])->with('success', 'Prestazione creata e assegnata automaticamente a tutti i membri staff del dipartimento!');
    }



    public function edit($id)
    {
        $prestazione = Prestazione::findOrFail($id);
        $dipartimenti = Dipartimento::all();
        return view('admin.prestazioni.edit', compact('prestazione', 'dipartimenti'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'descrizione' => 'required|string|max:255',
        ]);

        $prestazione = Prestazione::findOrFail($id);
        $prestazione->update([
            'nome' => $request->nome,
            'id_dipartimento' => $request->id_dipartimento,
            'descrizione' => $prestazione->descrizione
        ]);

        return redirect()->route('admin.prestazioni.index')->with('success', 'Prestazione aggiornata!');
    }

    public function destroy($id)
    {
        $prestazione = Prestazione::findOrFail($id);
        $prestazione->delete();
        return redirect()->route('admin.prestazioni.index')->with('success', 'Prestazione eliminata!');
    }
}
