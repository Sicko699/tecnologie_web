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
            'giorno_settimana' => 'required|integer|min:0|max:6', // 0 = Lunedì
            'orario_inizio' => 'required|date_format:H:i', // Es. 09:00
        ]);

        Agenda::create([
            'dipartimento_id' => $request->dipartimento_id,
            'prestazione_id' => $request->prestazione_id,
            'giorno_settimana' => $request->giorno_settimana,
            'orario_inizio' => $request->orario_inizio,
        ]);

        return redirect()->route('admin.agende.index')->with('success', 'Slot agende creato!');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $dipartimenti = Dipartimento::all();
        $prestazioni = Prestazione::all();
        return view('admin.agende.edit', compact('agenda', 'dipartimenti', 'prestazioni'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dipartimento_id' => 'required|exists:dipartimenti,id',
            'prestazione_id' => 'required|exists:prestazioni,id',
            'giorno_settimana' => 'required|integer|min:0|max:6',
            'orario_inizio' => 'required|date_format:H:i',
        ]);

        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'dipartimento_id' => $request->dipartimento_id,
            'prestazione_id' => $request->prestazione_id,
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
