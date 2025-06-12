<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembroStaffSeeder extends Seeder
{
    public function run()
    {
        DB::table('membro_staff')->insert([
            [
                'codice_fiscale' => 'STAFFSTAFF01A01A',
                'id_dipartimento' => 1,
            ]
        ]);
    }
}

