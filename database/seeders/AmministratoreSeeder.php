<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmministratoreSeeder extends Seeder
{
    public function run()
    {
        DB::table('amministratori')->insert([
            ['codice_fiscale' => 'RSSMRA85M01H501Z']
        ]);
    }
}
