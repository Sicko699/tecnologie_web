<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paziente;
use App\Models\User;

class PazienteSeeder extends Seeder
{
    public function run()
    {
        $pazienti = User::where('ruolo', 'paziente')->get();
        foreach ($pazienti as $u) {
            Paziente::factory()->create(['codice_fiscale' => $u->codice_fiscale]);
        }
    }
}
