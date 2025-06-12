<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medico;

class MedicoSeeder extends Seeder
{
    public function run()
    {
        $medici = [
            [
                'id'=>1,
                'nome' => 'Luca',
                'cognome' => 'Bianchi',
                'specializzazione' => 'Ortodonzia',
            ],
            [
                'id'=>2,
                'nome' => 'Giulia',
                'cognome' => 'Rossi',
                'specializzazione' => 'Chirurgia Orale',
            ],
            [
                'id'=>3,
                'nome' => 'Marco',
                'cognome' => 'Verdi',
                'specializzazione' => 'Igiene e Prevenzione',
            ],
        ];

        foreach ($medici as $medico) {
            Medico::create($medico);
        }
    }
}
