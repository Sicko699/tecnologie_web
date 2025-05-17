<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembroStaff;
use App\Models\User;
use App\Models\Dipartimento;

class MembroStaffSeeder extends Seeder
{
    public function run()
    {
        $dipartimenti = Dipartimento::all();
        $staff = User::where('ruolo', 'staff')->get();
        foreach ($staff as $i => $u) {
            MembroStaff::factory()->create([
                'codice_fiscale' => $u->codice_fiscale,
                'id_dipartimento' => $dipartimenti[$i % $dipartimenti->count()]->id_dipartimento
            ]);
        }
    }
}
