<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        ]);

        Prestazione::create([
            'nome' => $request->nome,
            'id_dipartimento' => $request->id_dipartimento,
        ]);

        return redirect()->route('admin.prestazioni.index')->with('success', 'Prestazione creata!');
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
        ]);

        $prestazione = Prestazione::findOrFail($id);
        $prestazione->update([
            'nome' => $request->nome,
            'id_dipartimento' => $request->id_dipartimento,
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
