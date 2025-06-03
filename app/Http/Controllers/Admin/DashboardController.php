<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dipartimento;
use App\Models\Prestazione;
use App\Models\MembroStaff;
use App\Models\Agenda; // <-- aggiungi questa riga!

class DashboardController extends Controller
{
    public function index()
    {
        // Conteggi da visualizzare nella dashboard
        $dipartimentiCount = Dipartimento::count();
        $prestazioniCount = Prestazione::count();
        $utentiCount = MembroStaff::count();
        $agendeCount = Agenda::count(); // <-- aggiungi questa riga

        // Dati placeholder per grafico (puoi sostituirli con query reali)
        $chartLabels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'];
        $chartData = [10, 20, 15, 30, 25, 40];

        return view('admin.dashboard', compact(
            'dipartimentiCount',
            'prestazioniCount',
            'utentiCount',
            'agendeCount',      // <-- aggiungi qui!
            'chartLabels',
            'chartData'
        ));
    }
}
