<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Puoi aggiungere dati riepilogativi, grafici, statistiche rapide
        return view('admin.dashboard');
    }
}
