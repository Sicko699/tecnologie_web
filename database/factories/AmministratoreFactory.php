<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AmministratoreFactory extends Factory
{
    public function definition()
    {
        return [
            'codice_fiscale' => null, // impostato dal seeder (FK users)
        ];
    }
}
