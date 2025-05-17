<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dipartimento;

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
            'nome' => 'required|max:255',
            'descrizione' => 'nullable|string|max:255'
        ]);
        Dipartimento::create($request->only('nome', 'descrizione'));
        return redirect()->route('admin.dipartimenti.index')->with('success', 'Dipartimento creato!');
    }

    public function show($id)
    {
        $dipartimento = Dipartimento::findOrFail($id);
        return view('admin.dipartimenti.show', compact('dipartimento'));
    }

    public function edit($id)
    {
        $dipartimento = Dipartimento::findOrFail($id);
        return view('admin.dipartimenti.edit', compact('dipartimento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable|string|max:255'
        ]);
        $dipartimento = Dipartimento::findOrFail($id);
        $dipartimento->update($request->only('nome', 'descrizione'));
        return redirect()->route('admin.dipartimenti.index')->with('success', 'Dipartimento aggiornato!');
    }

    public function destroy($id)
    {
        $dipartimento = Dipartimento::findOrFail($id);
        $dipartimento->delete();
        return redirect()->route('admin.dipartimenti.index')->with('success', 'Dipartimento eliminato!');
    }
}
