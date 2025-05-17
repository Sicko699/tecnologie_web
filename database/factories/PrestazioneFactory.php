<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PrestazioneFactory extends Factory
{
    public function definition()
    {
        return [
            'nome' => 'Prestazione ' . $this->faker->unique()->word,
            'descrizione' => $this->faker->sentence,
            'id_dipartimento' => null, // impostato dal seeder
            'id_membro' => null,       // impostato dal seeder
        ];
    }
}
