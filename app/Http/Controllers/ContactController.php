<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        // Mostra la pagina contatti (contact.blade.php)
        return view('contact');
    }

    // (Opzionale) Gestione invio form di contatto
    public function send(Request $request)
    {
        // Validazione semplice (aggiungi campi secondo il form)
        $request->validate([
            'nome'    => 'required|string|max:100',
            'email'   => 'required|email',
            'oggetto' => 'nullable|string|max:255',
            'messaggio' => 'required|string'
        ]);
        // Puoi inviare email, salvare richiesta, ecc.
        // Mail::to('info@studiosmile.it')->send(new ContactMessage($request->all()));
        return redirect()->back()->with('success', 'Messaggio inviato con successo!');
    }
}
