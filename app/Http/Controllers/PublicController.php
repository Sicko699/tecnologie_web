<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prestazione;
use App\Models\Dipartimento;


class PublicController extends Controller
{
    public function home()
    {
        $trattamenti = Prestazione::with('dipartimento')->get();
        $dipartimenti = Dipartimento::all();
        $dottori = User::whereHas('membroStaff')->get();

        $medicoInEvidenza = User::whereHas('membroStaff')->inRandomOrder()->first();

        return view('public.home', compact('trattamenti', 'dipartimenti', 'dottori', 'medicoInEvidenza'));
    }

    public function about()
    {
        $medico = User::whereHas('membroStaff')->inRandomOrder()->first();

        return view('public.about', compact('medico'));
    }

    public function doctor(){
        // Mostra elenco staff con ruolo "staff" o "dottore"
        $dottori = User::whereHas('membroStaff')->get();
        return view('public.doctor', compact('dottori'));
    }

    public function department(){
        $trattamenti = Prestazione::with('dipartimento')->get();
        return view('public.department', compact('trattamenti'));
    }

    public function contact(){
        return view('public.contact');
    }
}
