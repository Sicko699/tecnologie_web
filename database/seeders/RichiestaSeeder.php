<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RichiestaSeeder extends Seeder
{
    public function run()
    {
        DB::table('richieste')->insert([
            [
                'id_richiesta' => 1,
                'id_utente' => 'PAZIPAZI01A01A',
                'id_prestazione' => 2,
                'id_dipartimento' => 2,
                'giorno_escluso' => 'Venerdì',
                'stato' => 'in attesa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_richiesta' => 2,
                'id_utente' => 'PAZIPAZI01A01A',
                'id_prestazione' => 3,
                'id_dipartimento' => 3,
                'giorno_escluso' => 'Giovedì',
                'stato' => 'in attesa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_richiesta' => 3,
                'id_utente' => 'PAZIPAZI01A01A',
                'id_prestazione' => 2,
                'id_dipartimento' => 2,
                'giorno_escluso' => 'Sabato',
                'stato' => 'in attesa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
