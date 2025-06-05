<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgendaSeeder extends Seeder
{
    public function run()
    {
        DB::table('agende')->insert([
            [
                'id_dipartimento' => 1,
                'id_prestazione' => 2,
                'giorni_settimana' => json_encode(['lunedì', 'mercoledì']),
                'configurazione_orari' => json_encode(['inizio' => '09:00', 'fine' => '17:00']),
                'max_appuntamenti' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

