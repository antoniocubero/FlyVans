<?php

namespace Database\Factories;

use App\Models\Caravana;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaravanaFactory extends Factory
{
    protected $model = Caravana::class;

    public function definition(): array
    {
        return [
            'id_usuario_propietario' => User::inRandomOrder()->first()->id,
            'matricula' => strtoupper($this->faker->bothify('####-???')),
            'marca' => $this->faker->randomElement(['Peugeot', 'Volkswagen', 'Renault', 'Fiat', 'Citroen']),
            'modelo' => $this->faker->word(),
            'kilometraje' => $this->faker->numberBetween(0, 200000),
            'nota' => $this->faker->randomFloat(1, 1, 5),
        ];
    }
}
