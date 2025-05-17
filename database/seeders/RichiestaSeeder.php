<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Richiesta;
use App\Models\User;
use App\Models\Prestazione;

class RichiestaSeeder extends Seeder
{
    public function run()
    {
        $pazienti = User::where('ruolo', 'paziente')->get();
        $prestazioni = Prestazione::all();

        foreach ($pazienti as $paziente) {
            foreach ($prestazioni->random(2) as $prestazione) {
                Richiesta::factory()->create([
                    'id_utente' => $paziente->codice_fiscale,
                    'id_prestazione' => $prestazione->id_prestazione
                ]);
            }
        }
    }
}
