<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MembroStaffFactory extends Factory
{
    public function definition()
    {
        return [
            'codice_fiscale' => null,   // impostato dal seeder (FK users)
            'id_dipartimento' => null,  // impostato dal seeder
            'descrizione' => $this->faker->sentence
        ];
    }
}
