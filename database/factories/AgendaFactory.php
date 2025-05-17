<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaFactory extends Factory
{
    public function definition()
    {
        return [
            'id_prestazione' => null, // impostato dal seeder
            'giorno_settimana' => $this->faker->randomElement(['Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì']),
            'slot_orario' => $this->faker->randomElement(['08:30-09:30','09:30-10:30','10:30-11:30','11:30-12:30']),
            'max_appuntamenti' => $this->faker->numberBetween(1, 4),
        ];
    }
}
