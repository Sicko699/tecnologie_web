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
        $nome = $request->input('nome');
        $cognome = $request->input('cognome');

        $dateFilter = function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('data', [$start, $end]);
            }
        };

        $base = Appuntamento::where($dateFilter)
            ->with('richiesta.prestazione', 'richiesta.dipartimento', 'richiesta.utente');

        $prestazioniCount = (clone $base)->get()
            ->groupBy(fn($a) => optional($a->richiesta->prestazione)->nome)
            ->map(fn($items) => count($items));

        $dipartimentiCount = (clone $base)->get()
            ->groupBy(fn($a) => optional($a->richiesta->dipartimento)->nome)
            ->map(fn($items) => count($items));

        $prestazioniUtente = null;
        if ($nome && $cognome) {
            $prestazioniUtente = (clone $base)
                ->get()
                ->filter(function ($a) use ($nome, $cognome) {
                    $utente = optional($a->richiesta->utente);
                    return (
                        strcasecmp(trim($utente->nome ?? ''), trim($nome)) === 0 &&
                        strcasecmp(trim($utente->cognome ?? ''), trim($cognome)) === 0
                    );
                })->values();
        }

        if ($request->ajax()) {
            return response()->json([
                'prestazioniCount' => $prestazioniCount,
                'dipartimentiCount' => $dipartimentiCount,
                'prestazioniUtente' => $prestazioniUtente,
            ]);
        }

        return view('admin.statistiche.index', compact(
            'prestazioniCount',
            'dipartimentiCount',
            'prestazioniUtente'
        ));
    }
}
