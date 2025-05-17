<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DipartimentoFactory extends Factory
{
    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->word . 'logia',
            'descrizione' => $this->faker->sentence(5),
        ];
    }
}
