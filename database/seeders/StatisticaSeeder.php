<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistica;
use App\Models\Amministratore;
use App\Models\Prestazione;
use Illuminate\Support\Carbon;

class StatisticaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Amministratore::inRandomOrder()->first();
        $prestazione = Prestazione::inRandomOrder()->first();

        Statistica::create([
            'id_amministratore' => $admin->codice_fiscale,
            'id_prestazione' => $prestazione->id_prestazione,
            'data_inizio' => Carbon::now()->subMonth()->toDateString(),
            'data_fine' => Carbon::now()->toDateString(),
            'tipo' => 'frequenza',
            'risultato' => '50 appuntamenti eseguiti',
        ]);
    }
}
