<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(10)->create(['ruolo' => 'paziente']);
        User::factory()->count(5)->create(['ruolo' => 'staff']);
        User::factory()->count(2)->create(['ruolo' => 'admin']);
    }
}
