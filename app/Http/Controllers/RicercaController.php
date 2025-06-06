<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestazione;

class RicercaController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q'));
        $risultati = collect();

        if ($query && strlen($query) >= 1) {
            $pattern = str_ends_with($query, '*')
                ? rtrim($query, '*') . '%'
                : $query;

            $risultati = Prestazione::where('nome', 'like', $pattern)
                ->orWhereHas('dipartimento', function($q2) use ($pattern) {
                    $q2->where('nome', 'like', $pattern);
                })
                ->with('dipartimento')
                ->get();
        }

        return view('ricerca.risultati', compact('risultati'));
    }
}
