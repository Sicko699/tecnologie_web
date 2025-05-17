<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppuntamentoFactory extends Factory
{
    public function definition()
    {
        return [
            'id_richiesta' => null, // impostato dal seeder
            'data' => $this->faker->dateTimeBetween('now', '+2 months'),
            'ora' => $this->faker->randomElement(['08:30', '10:00', '12:00', '15:00', '16:30']),
            'stato' => $this->faker->randomElement(['prenotato', 'completato', 'annullato']),
        ];
    }
}
