<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Dipartimento;
use App\Models\Prestazione;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $agende = Agenda::with(['dipartimento', 'prestazione'])->get();
        return view('admin.agende.index', compact('agende'));
    }

    public function create()
    {
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.create', compact('dipartimenti', 'prestazioni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dipartimento_id' => 'required|exists:dipartimenti,id',
            'prestazione_id' => 'required|exists:prestazioni,id',
            'giorno_settimana' => 'required|integer|min:0|max:6',
            'orari' => 'required|string'
        ]);

        $orari = array_map('trim', explode(',', $request->orari));

        foreach ($orari as $orario) {
            if (!preg_match('/^\d{2}:\d{2}$/', $orario)) {
                return back()->withErrors(['orari' => "Formato orario non valido: $orario"]);
            }

            Agenda::create([
                'id_dipartimento' => $request->id_dipartimento,
                'id_prestazione' => $request->id_prestazione,
                'giorno_settimana' => $request->giorno_settimana,
                'orario_inizio' => $orario,
            ]);

        }

        return redirect()->route('admin.agende.index')->with('success', 'Slot agenda creati!');
    }

    public function edit($id_agenda)
    {
        $agenda = Agenda::findOrFail($id_agenda);
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.edit', compact('agenda', 'dipartimenti', 'prestazioni'));
    }

    public function update(Request $request, $id_agenda)
    {
        $request->validate([
            'id_dipartimento' => 'required|exists:dipartimenti,id_dipartimento',
            'id_prestazione' => 'required|exists:prestazioni,id_prestazione',
            'giorno_settimana' => 'required|integer|min:0|max:6',
            'orari' => 'required|string'
        ]);


        $agenda = Agenda::findOrFail($id_agenda);
        $agenda->update([
            'id_dipartimento' => $request->id_dipartimento,
            'id_prestazione' => $request->id_prestazione,
            'giorno_settimana' => $request->giorno_settimana,
            'orario_inizio' => $request->orario_inizio,
        ]);


        return redirect()->route('admin.agende.index')->with('success', 'Slot agende aggiornato!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agende.index')->with('success', 'Slot agende eliminato!');
    }
}
