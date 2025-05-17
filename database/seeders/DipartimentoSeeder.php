<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dipartimento;

class DipartimentoSeeder extends Seeder
{
    public function run()
    {
        Dipartimento::factory()->count(4)->create();
    }
}
