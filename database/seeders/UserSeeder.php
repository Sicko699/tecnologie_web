<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $pw = '9wNl' . '9wNl';

        User::create([
            'codice_fiscale' => 'PAZIPAZI01A01A',
            'nome' => 'Utente',
            'cognome' => 'Esterno',
            'username' => 'pazipazi',
            'email' => 'pazipazi@email.com',
            'password' => Hash::make($pw),
            'telefono' => '3331234567',
            'data_nascita' => '2000-01-01',
            'ruolo' => 'paziente',
        ]);

        User::create([
            'codice_fiscale' => 'STAFFSTAFF01A01A',
            'nome' => 'Staff',
            'cognome' => 'Membro',
            'username' => 'staffstaff',
            'email' => 'staffstaff@email.com',
            'password' => Hash::make($pw),
            'telefono' => '3339876543',
            'data_nascita' => '1990-01-01',
            'ruolo' => 'staff',
        ]);

        User::create([
            'codice_fiscale' => 'ADMINADMIN01A01A',
            'nome' => 'Admin',
            'cognome' => 'Utente',
            'username' => 'adminadmin',
            'email' => 'adminadmin@email.com',
            'password' => Hash::make($pw),
            'telefono' => '3331112233',
            'data_nascita' => '1980-01-01',
            'ruolo' => 'admin',
        ]);
    }
}
