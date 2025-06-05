<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'codice_fiscale' => 'RSSMRA85M01H501Z',
                'username' => 'admin1',
                'nome' => 'Mario',
                'cognome' => 'Rossi',
                'email' => 'admin@studio.it',
                'password' => Hash::make('password'),
                'telefono' => '3201234567',
                'data_nascita' => '1985-01-01',
                'ruolo' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codice_fiscale' => 'BNCGPP90A01F205T',
                'username' => 'staff1',
                'nome' => 'Giuseppe',
                'cognome' => 'Bianchi',
                'email' => 'staff@studio.it',
                'password' => Hash::make('password'),
                'telefono' => '3298765432',
                'data_nascita' => '1990-01-01',
                'ruolo' => 'staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codice_fiscale' => 'VRDLGI95C10H501A',
                'username' => 'paziente1',
                'nome' => 'Lucia',
                'cognome' => 'Verdi',
                'email' => 'lucia@studio.it',
                'password' => Hash::make('password'),
                'telefono' => '3381234567',
                'data_nascita' => '1995-03-10',
                'ruolo' => 'paziente',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

