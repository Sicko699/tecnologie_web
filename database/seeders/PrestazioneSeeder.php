<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestazione;
use App\Models\Dipartimento;
use App\Models\MembroStaff;

class PrestazioneSeeder extends Seeder
{
    public function run()
    {
        $dipartimenti = Dipartimento::all();
        $membri = MembroStaff::all();

        foreach ($dipartimenti as $dep) {
            foreach ($membri as $membro) {
                Prestazione::factory()->create([
                    'id_dipartimento' => $dep->id_dipartimento,
                    'id_membro' => $membro->codice_fiscale
                ]);
            }
        }
    }
}
