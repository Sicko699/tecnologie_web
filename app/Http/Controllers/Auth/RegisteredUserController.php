<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'codice_fiscale' => ['required', 'string', 'size:16', 'unique:users,codice_fiscale'],
            'nome'           => ['required', 'string', 'max:100'],
            'cognome'        => ['required', 'string', 'max:100'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telefono'       => ['nullable', 'string', 'max:50'],
            'data_nascita'   => ['nullable', 'date'],
            'foto'           => ['nullable', 'image', 'max:2048'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Gestione upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profili', 'public');
        }

        $user = User::create([
            'codice_fiscale' => strtoupper($request->codice_fiscale),
            'nome'           => $request->nome,
            'cognome'        => $request->cognome,
            'email'          => $request->email,
            'telefono'       => $request->telefono,
            'data_nascita'   => $request->data_nascita,
            'foto'           => $fotoPath,
            'ruolo'          => 'paziente',
            'password'       => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
