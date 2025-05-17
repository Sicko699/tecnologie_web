<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistica;
use App\Models\Amministratore;
use App\Models\Prestazione;

class StatisticaSeeder extends Seeder
{
    public function run()
    {
        $admin = Amministratore::all();
        $prestazioni = Prestazione::all();

        foreach ($admin as $a) {
            foreach ($prestazioni->random(2) as $prestazione) {
                Statistica::factory()->create([
                    'id_amministratore' => $a->codice_fiscale,
                    'id_prestazione' => $prestazione->id_prestazione
                ]);
            }
        }
    }
}
