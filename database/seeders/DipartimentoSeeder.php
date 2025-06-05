<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DipartimentoSeeder extends Seeder
{
    public function run()
    {
        DB::table('dipartimenti')->insert([
            ['nome' => 'Ortodonzia', 'descrizione' => 'Trattamenti per l’allineamento dei denti'],
            ['nome' => 'Chirurgia Orale', 'descrizione' => 'Estrazioni e chirurgia dentale'],
            ['nome' => 'Igiene e Prevenzione', 'descrizione' => 'Pulizie dentali e controlli periodici'],
            ['nome' => 'Estetica Dentale', 'descrizione' => 'Sbiancamento e faccette dentali'],
        ]);
    }
}

