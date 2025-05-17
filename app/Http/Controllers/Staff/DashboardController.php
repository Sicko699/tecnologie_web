<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Qui puoi aggiungere dati riepilogativi, esempio: appuntamenti del giorno
        return view('staff.dashboard');
    }
}
