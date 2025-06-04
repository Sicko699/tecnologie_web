<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Dipartimento;
use App\Models\Prestazione;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Appuntamento;

class DashboardController extends Controller
{
    public function index()
    {
        // Conteggi per le card
        $dipartimentiCount = Dipartimento::count();
        $prestazioniCount = Prestazione::count();
        $utentiCount = User::whereIn('ruolo', ['admin', 'staff'])->count();
        $agendeCount = Agenda::count();

        // Dati per il grafico: ultimi 6 mesi
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $label = $month->format('M Y'); // Es: "Jun 2025"

            $count = Appuntamento::whereYear('data', $month->year)
                ->whereMonth('data', $month->month)
                ->count();

            $chartLabels[] = $label;
            $chartData[] = $count;
        }

        return view('admin.dashboard', compact(
            'dipartimentiCount',
            'prestazioniCount',
            'utentiCount',
            'agendeCount',
            'chartLabels',
            'chartData'
        ));
    }
}
