<?php

namespace App\Http\Controllers;

use App\Models\MembroStaff;
use App\Models\User;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class MembroStaffController extends Controller
{
    public function index()
    {
        $membri = MembroStaff::with(['user', 'dipartimento'])->get();
        return view('membri_staff.index', compact('membri'));
    }

    public function create()
    {
        $utenti = User::all();
        $dipartimenti = Dipartimento::all();
        return view('membri_staff.create', compact('utenti', 'dipartimenti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codice_fiscale' => 'required|exists:users,codice_fiscale',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento'
        ]);
        MembroStaff::create($request->all());
        return redirect()->route('membri_staff.index')->with('success', 'Membro staff aggiunto!');
    }

    public function show($codice_fiscale)
    {
        $membro = MembroStaff::with(['user', 'dipartimento'])->findOrFail($codice_fiscale);
        return view('membri_staff.show', compact('membro'));
    }

    public function edit($codice_fiscale)
    {
        $membro = MembroStaff::findOrFail($codice_fiscale);
        $utenti = User::all();
        $dipartimenti = Dipartimento::all();
        return view('membri_staff.edit', compact('membro', 'utenti', 'dipartimenti'));
    }

    public function update(Request $request, $codice_fiscale)
    {
        $request->validate([
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento'
        ]);
        $membro = MembroStaff::findOrFail($codice_fiscale);
        $membro->update($request->all());
        return redirect()->route('membri_staff.index')->with('success', 'Membro staff aggiornato!');
    }

    public function destroy($codice_fiscale)
    {
        $membro = MembroStaff::findOrFail($codice_fiscale);
        $membro->delete();
        return redirect()->route('membri_staff.index')->with('success', 'Membro staff eliminato!');
    }
}
