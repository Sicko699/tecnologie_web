<?php

namespace App\Http\Controllers;

use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class PrestazioneController extends Controller
{
    public function index()
    {
        $prestazioni = Prestazione::with('medico')->get();
        return view('prestazioni.index', compact('prestazioni'));
    }

    public function show($id)
    {
        $prestazione = Prestazione::with('medico')->findOrFail($id);
        return view('prestazioni.show', compact('prestazione'));
    }
}
