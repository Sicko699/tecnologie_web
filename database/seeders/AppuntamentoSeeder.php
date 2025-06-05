<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appuntamento;
use App\Models\Richiesta;
use Illuminate\Support\Carbon;

class AppuntamentoSeeder extends Seeder
{
    public function run(): void
    {
        $richiesta = Richiesta::inRandomOrder()->first();

        Appuntamento::create([
            'id_richiesta' => $richiesta->id_richiesta,
            'data' => Carbon::now()->addDays(3)->toDateString(),
            'ora' => '10:00:00',
            'stato' => 'prenotato',
        ]);
    }
}
