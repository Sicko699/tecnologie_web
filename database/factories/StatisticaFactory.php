<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticaFactory extends Factory
{
    public function definition()
    {
        $inizio = $this->faker->dateTimeBetween('-1 year', 'now');
        $fine = $this->faker->dateTimeBetween($inizio, '+2 months');
        return [
            'id_amministratore' => null, // impostato dal seeder
            'id_prestazione' => null,    // impostato dal seeder
            'data_inizio' => $inizio,
            'data_fine' => $fine,
            'tipo' => $this->faker->randomElement(['num_prenotazioni', 'num_appuntamenti', 'tempo_medio']),
            'risultato' => $this->faker->randomNumber(3),
        ];
    }
}
