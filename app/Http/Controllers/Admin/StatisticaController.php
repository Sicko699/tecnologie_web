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
        $codiceFiscale = $request->input('utente_id');

        $dateFilter = function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('data', [$start, $end]);
            }
        };

        $base = Appuntamento::where($dateFilter)->with('richiesta.prestazione', 'richiesta.dipartimento', 'richiesta.utente');

        $prestazioniCount = (clone $base)->get()
            ->groupBy(fn($a) => optional($a->richiesta->prestazione)->nome)
            ->map(fn($items) => count($items));

        $dipartimentiCount = (clone $base)->get()
            ->groupBy(fn($a) => optional($a->richiesta->dipartimento)->nome)
            ->map(fn($items) => count($items));

        $prestazioniUtente = null;
        if ($codiceFiscale) {
            $prestazioniUtente = (clone $base)
                ->get()
                ->filter(fn($a) => optional($a->richiesta->utente)->codice_fiscale === $codiceFiscale);
        }

        return view('admin.statistiche.index', compact(
            'prestazioniCount',
            'dipartimentiCount',
            'prestazioniUtente'
        ));

    }
}
