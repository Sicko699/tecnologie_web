<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestazioneSeeder extends Seeder
{
    public function run()
    {
        DB::table('prestazioni')->insert([
            [
                'nome' => 'Igiene orale professionale',
                'descrizione' => 'Pulizia completa dei denti con ablazione del tartaro',
                'id_dipartimento' => 3,
            ],
            [
                'nome' => 'Apparecchio fisso',
                'descrizione' => 'Trattamento ortodontico con brackets',
                'id_dipartimento' => 1,
            ]
        ]);
    }
}

