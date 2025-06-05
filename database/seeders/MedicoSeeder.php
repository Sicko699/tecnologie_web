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
                'nome' => 'Luca',
                'cognome' => 'Bianchi',
                'specializzazione' => 'Ortodonzia',
            ],
            [
                'nome' => 'Giulia',
                'cognome' => 'Rossi',
                'specializzazione' => 'Chirurgia Orale',
            ],
            [
                'nome' => 'Marco',
                'cognome' => 'Verdi',
                'specializzazione' => 'Igiene e Prevenzione',
            ],
            [
                'nome' => 'Sara',
                'cognome' => 'Esposito',
                'specializzazione' => 'Estetica Dentale',
            ],
            [
                'nome' => 'Francesco',
                'cognome' => 'Romano',
                'specializzazione' => 'Implantologia',
            ],
        ];

        foreach ($medici as $medico) {
            Medico::create($medico);
        }
    }
}
