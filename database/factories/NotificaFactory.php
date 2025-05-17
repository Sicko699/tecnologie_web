<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificaFactory extends Factory
{
    public function definition()
    {
        return [
            'id_utente' => null, // impostato dal seeder
            'messaggio' => $this->faker->sentence,
            'data_creazione' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'conferma_lettura' => $this->faker->boolean(30),
        ];
    }
}
