<?php

namespace Database\Seeders;

use App\Models\MembroStaff;
use App\Models\Prestazione;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AmministratoreSeeder::class,
            PazienteSeeder::class,
            DipartimentoSeeder::class,
            MembroStaffSeeder::class,
            PrestazioneSeeder::class,
            RichiestaSeeder::class,
            AgendaSeeder::class,
            MedicoSeeder::class,
        ]);
    }
}

