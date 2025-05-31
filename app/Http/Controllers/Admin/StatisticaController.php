<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appuntamento;
use Illuminate\Http\Request;

class StatisticaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = Appuntamento::query();
        if ($start && $end) {
            $query->whereBetween('data', [$start, $end]);
        }

        // 1. Numero prestazioni per tipo
        $prestazioniCount = $query->clone()->selectRaw('prestazione_id, count(*) as totale')
            ->groupBy('prestazione_id')->with('prestazione')->get();

        // 2. Numero prestazioni per dipartimento
        $dipartimentiCount = $query->clone()->selectRaw('dipartimento_id, count(*) as totale')
            ->groupBy('dipartimento_id')->with('dipartimento')->get();

        // 3. Tutte le prestazioni erogate ad utente esterno specificato
        $utente_id = $request->input('utente_id');
        $prestazioniUtente = null;
        if ($utente_id) {
            $prestazioniUtente = $query->clone()->where('utente_id', $utente_id)
                ->with('prestazione', 'dipartimento')->get();
        }

        return view('admin.statistiche.index', compact('prestazioniCount', 'dipartimentiCount', 'prestazioniUtente'));
    }
}
