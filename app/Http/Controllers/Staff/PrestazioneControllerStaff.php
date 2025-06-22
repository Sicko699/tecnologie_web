<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\MembroStaff;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestazioneControllerStaff extends Controller
{
    public function index()
    {
        $membro = Auth::user()->membroStaff;
        if (!$membro) {
            $prestazioni = collect();
        } else {
            $prestazioni = Prestazione::where('id_dipartimento', $membro->id_dipartimento)
                ->with('dipartimento')
                ->get();
        }

        return view('staff.prestazioni.index', compact('prestazioni'));
    }

    public function create()
    {
        $membro = Auth::user()->membroStaff;
        $dipartimenti = $membro ? Dipartimento::where('id_dipartimento', $membro->id_dipartimento)->get() : collect();
        return view('staff.prestazioni.create', compact('dipartimenti'));
    }

    public function store(Request $request)
    {
        $membro = Auth::user()->membroStaff;
        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable',
            'id_dipartimento' => [
                'required',
                function ($attribute, $value, $fail) use ($membro) {
                    if ($membro && $value != $membro->id_dipartimento) {
                        $fail('Non puoi creare prestazioni per altri dipartimenti.');
                    }
                }
            ],
        ]);

        $prestazione = Prestazione::create([
            'nome' => $request->nome,
            'descrizione' => $request->descrizione,
            'id_dipartimento' => $request->id_dipartimento,
        ]);

        if ($membro) {
            $membro->prestazioni()->attach($prestazione->id_prestazione);
        }

        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione creata!');
    }

    public function edit($id)
    {
        $membro = Auth::user()->membroStaff;
        $prestazione = Prestazione::where('id_prestazione', $id)
            ->where('id_dipartimento', $membro ? $membro->id_dipartimento : null)
            ->firstOrFail();

        $dipartimenti = $membro
            ? Dipartimento::where('id_dipartimento', $membro->id_dipartimento)->get()
            : collect();

        return view('staff.prestazioni.edit', compact('prestazione', 'dipartimenti'));
    }

    public function update(Request $request, $id)
    {
        $membro = Auth::user()->membroStaff;
        $prestazione = Prestazione::where('id_prestazione', $id)
            ->where('id_dipartimento', $membro ? $membro->id_dipartimento : null)
            ->firstOrFail();

        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable',
            'id_dipartimento' => [
                'required',
                function ($attribute, $value, $fail) use ($membro) {
                    if ($membro && $value != $membro->id_dipartimento) {
                        $fail('Non puoi modificare il dipartimento.');
                    }
                }
            ],
        ]);

        $prestazione->update($request->only('nome', 'descrizione', 'id_dipartimento'));

        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione aggiornata!');
    }

    public function destroy($id)
    {
        $membro = Auth::user()->membroStaff;
        $prestazione = Prestazione::where('id_prestazione', $id)
            ->where('id_dipartimento', $membro ? $membro->id_dipartimento : null)
            ->firstOrFail();

        $membro->prestazioni()->detach($id);

        if ($prestazione->membriStaff()->count() === 0) {
            $prestazione->delete();
        }

        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione eliminata!');
    }

    public function editGestionePrestazioni($codice_fiscale)
    {
        $membro = MembroStaff::findOrFail($codice_fiscale);
        $dipartimentoId = $membro->id_dipartimento;
        $prestazioni = Prestazione::where('id_dipartimento', $dipartimentoId)->get();
        $prestazioniGestite = $membro->prestazioni->pluck('id_prestazione')->toArray();

        return view('staff.membri.edit_prestazioni', compact('membro', 'prestazioni', 'prestazioniGestite'));
    }

    public function updateGestionePrestazioni(Request $request, $codice_fiscale)
    {
        $membro = MembroStaff::findOrFail($codice_fiscale);

        $prestazioniIds = $request->input('prestazioni', []);

        $membro->prestazioni()->sync($prestazioniIds);

        return redirect()->route('staff.membri.index')->with('success', 'Prestazioni assegnate aggiornate!');
    }
}
