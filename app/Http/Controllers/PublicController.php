<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home');
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
