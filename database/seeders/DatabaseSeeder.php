<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DipartimentoSeeder::class,
            UserSeeder::class,
            PazienteSeeder::class,
            MembroStaffSeeder::class,
            AmministratoreSeeder::class,
            PrestazioneSeeder::class,
            RichiestaSeeder::class,
            AppuntamentoSeeder::class,
            AgendaSeeder::class,
            NotificaSeeder::class,
            StatisticaSeeder::class,
        ]);
    }
}
