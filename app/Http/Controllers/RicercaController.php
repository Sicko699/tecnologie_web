<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestazione;

class RicercaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $risultati = collect();
        if ($query) {
            $pattern = (substr($query, -1) === '*')
                ? rtrim($query, '*') . '%'
                : $query;
            $risultati = Prestazione::where('nome', 'like', $pattern)
                ->orWhereHas('dipartimento', function($q2) use ($pattern) {
                    $q2->where('nome', 'like', $pattern);
                })->get();
        }
        return view('ricerca.risultati', compact('risultati'));
    }
}
