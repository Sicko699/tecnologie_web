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

        // Controlla che il membro esista
        if (!$membro) {
            $prestazioni = collect();
        } else {
            // Recupera il dipartimento associato al membro staff
            $dipartimento = \App\Models\Dipartimento::find($membro->id_dipartimento);

            // Se trova il dipartimento, recupera le sue prestazioni
            if ($dipartimento) {
                $prestazioni = $dipartimento->prestazioni()->with('dipartimento')->get();
            } else {
                $prestazioni = collect();
            }
        }

        return view('staff.prestazioni.index', compact('prestazioni'));
    }


    // Form creazione prestazione
    public function create()
    {
        $dipartimenti = Dipartimento::all();
        return view('staff.prestazioni.create', compact('dipartimenti'));
    }

    // Salva nuova prestazione (e collega il membro staff autenticato tramite pivot)
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
        ]);

        // 1. Crea la prestazione
        $prestazione = Prestazione::create([
            'nome' => $request->nome,
            'descrizione' => $request->descrizione,
            'id_dipartimento' => $request->id_dipartimento,
        ]);

        // 2. Collega subito la prestazione al membro staff autenticato (tabella pivot)
        $membro = Auth::user()->membroStaff;
        if ($membro) {
            $membro->prestazioni()->attach($prestazione->id_prestazione);
        }

        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione creata!');
    }

    // Form modifica prestazione (solo se associata allo staff corrente)
    public function edit($id)
    {
        $membro = Auth::user()->membroStaff;
        $prestazione = $membro
            ? $membro->prestazioni()->where('prestazioni.id_prestazione', $id)->firstOrFail()
            : abort(403);

        $dipartimenti = Dipartimento::all();
        return view('staff.prestazioni.edit', compact('prestazione', 'dipartimenti'));
    }

    // Aggiorna prestazione (solo se associata allo staff corrente)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'descrizione' => 'nullable',
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
        ]);

        $membro = Auth::user()->membroStaff;
        $prestazione = $membro
            ? $membro->prestazioni()->where('prestazioni.id_prestazione', $id)->firstOrFail()
            : abort(403);

        $prestazione->update($request->only('nome', 'descrizione', 'id_dipartimento'));

        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione aggiornata!');
    }

    // Elimina prestazione (solo se associata allo staff corrente)
    public function destroy($id)
    {
        $membro = Auth::user()->membroStaff;
        if (!$membro) abort(403);

        // Stacca la prestazione dalla pivot (quindi non è più gestita dallo staff)
        $membro->prestazioni()->detach($id);

        // Se nessun altro membro staff la gestisce, elimina proprio la prestazione
        $prestazione = Prestazione::find($id);
        if ($prestazione && $prestazione->membriStaff()->count() === 0) {
            $prestazione->delete();
        }

        return redirect()->route('staff.prestazioni.index')->with('success', 'Prestazione eliminata!');
    }

    // Assegna prestazioni a uno staff (admin)
    public function editGestionePrestazioni($codice_fiscale)
    {
        $membro = MembroStaff::findOrFail($codice_fiscale);
        $prestazioni = Prestazione::all();
        $prestazioniGestite = $membro->prestazioni->pluck('id_prestazione')->toArray();

        return view('staff.membri.edit_prestazioni', compact('membro', 'prestazioni', 'prestazioniGestite'));
    }

    public function updateGestionePrestazioni(Request $request, $codice_fiscale)
    {
        $membro = MembroStaff::findOrFail($codice_fiscale);

        // Lista degli id delle prestazioni selezionate
        $prestazioniIds = $request->input('prestazioni', []); // array di id_prestazione

        // Aggiorna la tabella pivot
        $membro->prestazioni()->sync($prestazioniIds);

        return redirect()->route('staff.membri.index')->with('success', 'Prestazioni assegnate aggiornate!');
    }
}
