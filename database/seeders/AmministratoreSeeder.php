<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amministratore;
use App\Models\User;

class AmministratoreSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('ruolo', 'admin')->get();
        foreach ($admin as $u) {
            Amministratore::factory()->create(['codice_fiscale' => $u->codice_fiscale]);
        }
    }
}
