<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'codice_fiscale' => strtoupper($this->faker->unique()->bothify('????????????????')),
            'nome' => $this->faker->firstName,
            'cognome' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'telefono' => $this->faker->phoneNumber,
            'data_nascita' => $this->faker->date('Y-m-d', '2003-12-31'),
            'foto' => null,
            'ruolo' => $this->faker->randomElement(['paziente','staff','admin']),
            'remember_token' => Str::random(10),
        ];
    }
}
