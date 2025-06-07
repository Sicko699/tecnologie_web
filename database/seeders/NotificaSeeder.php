<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifica;
use App\Models\User;

class NotificaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('ruolo', 'paziente')->inRandomOrder()->first();

        Notifica::create([
            'codice_fiscale' => $user->codice_fiscale,
            'messaggio' => 'Hai un nuovo appuntamento prenotato.',
        ]);
    }
}
