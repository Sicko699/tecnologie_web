<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appuntamento;
use App\Models\Richiesta;

class AppuntamentoSeeder extends Seeder
{
    public function run()
    {
        $richieste = Richiesta::all();

        foreach ($richieste as $richiesta) {
            Appuntamento::factory()->create([
                'id_richiesta' => $richiesta->id_richiesta
            ]);
        }
    }
}
