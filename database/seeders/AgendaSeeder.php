<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\Prestazione;

class AgendaSeeder extends Seeder
{
    public function run()
    {
        $prestazioni = Prestazione::all();
        foreach ($prestazioni as $prestazione) {
            Agenda::factory()->count(3)->create([
                'id_prestazione' => $prestazione->id_prestazione
            ]);
        }
    }
}
