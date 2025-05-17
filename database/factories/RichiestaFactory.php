<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RichiestaFactory extends Factory
{
    public function definition()
    {
        return [
            'id_utente' => null,       // impostato dal seeder
            'id_prestazione' => null,  // impostato dal seeder
            'data_richiesta' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'giorno_escluso' => null,
            'stato' => $this->faker->randomElement(['in attesa', 'accettata', 'completata', 'rifiutata']),
        ];
    }
}
