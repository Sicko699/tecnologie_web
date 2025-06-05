<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\User;
use App\Models\Prestazione;
use App\Models\Dipartimento;


class PublicController extends Controller
{
    public function home()
    {
        $trattamenti = Prestazione::with('dipartimento')->get();
        $dipartimenti = Dipartimento::all();

        // Solo utenti con relazione "medico"
        $dottori = Medico::all();
        $medicoInEvidenza = Medico::inRandomOrder()->first();

        return view('public.home', compact('trattamenti', 'dipartimenti', 'dottori', 'medicoInEvidenza'));
    }

    public function doctor()
    {
        $dottori = Medico::all();
        return view('public.doctor', compact('dottori'));
    }


    public function about()
    {
        $medico = Medico::inRandomOrder()->first();

        return view('public.about', compact('medico'));
    }

    public function department(){
        $trattamenti = Prestazione::with(['dipartimento', 'medico'])->get();
        return view('public.department', compact('trattamenti'));
    }

    public function contact(){
        return view('public.contact');
    }

    public function show($id)
    {
        $prestazione = Prestazione::with(['medico', 'dipartimento'])->findOrFail($id);
        return view('public.prestazioni_show', compact('prestazione'));
    }

}
