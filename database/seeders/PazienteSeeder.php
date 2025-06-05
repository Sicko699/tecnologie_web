<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PazienteSeeder extends Seeder
{
    public function run()
    {
        DB::table('pazienti')->insert([
            ['codice_fiscale' => 'VRDLGI95C10H501A']
        ]);
    }
}
