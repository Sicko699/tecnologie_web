<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifica;
use App\Models\User;

class NotificaSeeder extends Seeder
{
    public function run()
    {
        $utenti = User::all();
        foreach ($utenti as $utente) {
            Notifica::factory()->count(2)->create([
                'id_utente' => $utente->codice_fiscale
            ]);
        }
    }
}
