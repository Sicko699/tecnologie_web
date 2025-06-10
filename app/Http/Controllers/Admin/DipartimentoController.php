<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class DipartimentoController extends Controller
{
    public function index()
    {
        $dipartimenti = Dipartimento::all();
        return view('admin.dipartimenti.index', compact('dipartimenti'));
    }

    public function create()
    {
        return view('admin.dipartimenti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'required|string|max:255',
        ]);
        $dipartimento = Dipartimento::create([
            'nome' => $request->nome,
            'descrizione' => $request->descrizione,
        ]);

        return redirect()->route('admin.dipartimenti.index')->with('success', 'Dipartimento creato!');
    }

    public function edit(Dipartimento $dipartimenti)
    {
        $dipartimento = $dipartimenti;
        return view('admin.dipartimenti.edit', compact('dipartimento'));
    }

    public function update(Request $request, Dipartimento $dipartimenti)
    {
        $dipartimenti->update([
            'nome' => $request->nome,
            'descrizione' => $request->descrizione,
        ]);
        return redirect()->route('admin.dipartimenti.index')->with('success', 'Dipartimento aggiornato!');
    }

    public function destroy(Dipartimento $dipartimenti)
    {
        $dipartimenti->delete();
        return redirect()->route('admin.dipartimenti.index')->with('success', 'Dipartimento eliminato!');
    }

}
