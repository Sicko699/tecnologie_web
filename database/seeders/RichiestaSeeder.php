<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Richiesta;
use App\Models\User;
use App\Models\Prestazione;
use App\Models\Dipartimento;

class RichiestaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('ruolo', 'paziente')->inRandomOrder()->first();
        $prestazione = Prestazione::inRandomOrder()->first();
        $dipartimento = $prestazione->id_dipartimento;

        Richiesta::create([
            'id_utente' => $user->codice_fiscale,
            'id_prestazione' => $prestazione->id_prestazione,
            'id_dipartimento' => $dipartimento,
            'giorno_escluso' => 'lunedì',
            'stato' => 'in attesa',
        ]);
    }
}
