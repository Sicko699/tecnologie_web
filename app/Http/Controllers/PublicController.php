<?php

namespace App\Http\Controllers;

use App\Models\MembroStaff;
use App\Models\User;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $trattamenti = Prestazione::with('dipartimento')->get();
        $dipartimenti = Dipartimento::all();
        $dottori = User::whereHas('membroStaff')->get();
        return view('public.home', compact('trattamenti', 'dipartimenti', 'dottori'));
    }

    public function doctor()
    {
        // Mostra elenco staff con ruolo "staff" o "dottore"
        $dottori = User::whereHas('membroStaff')->get();
        return view('public.doctor', compact('dottori'));
    }

    public function department()
    {
        $trattamenti = Prestazione::with('dipartimento')->get();
        return view('public.department', compact('trattamenti'));
    }

    public function prezzi()
    {
        // Puoi aggiungere qui la logica per i prezzi
        return view('public.prezzi');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
