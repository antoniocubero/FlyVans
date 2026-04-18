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
        $marcasModelos = [
            'Volkswagen' => ['California', 'Grand California', 'Transporter Camper', 'Caddy California'],
            'Fiat' => ['Ducato Camper', 'Talento Camper', 'Doblo Camper', 'Fiorino Camper'],
            'Renault' => ['Trafic Camper', 'Master Camper', 'Kangoo Camper', 'Express Camper'],
            'Citroen' => ['SpaceTourer Camper', 'Jumper Camper', 'Berlingo Camper', 'Jumpy Camper'],
            'Peugeot' => ['Traveller Camper', 'Boxer Camper', 'Rifter Camper', 'Expert Camper'],
            'Ford' => ['Transit Nugget', 'Transit Custom Nugget', 'Transit Camper', 'Tourneo Custom Camper'],
            'Mercedes-Benz' => ['Marco Polo', 'Sprinter Camper', 'Vito Camper', 'Citan Camper'],
            'Nissan' => ['NV300 Camper', 'NV200 Camper', 'Primastar Camper', 'Townstar Camper'],
            'Opel' => ['Vivaro Camper', 'Movano Camper', 'Combo Camper', 'Zafira Life Camper'],
            'Toyota' => ['Proace Camper', 'Proace City Camper', 'Hiace Camper'],
        ];

        $marca = $this->faker->randomElement(array_keys($marcasModelos));
        $modelo = $this->faker->randomElement($marcasModelos[$marca]);

        return [
            'id_usuario_propietario' => User::inRandomOrder()->first()->id ?? User::factory(),
            'matricula' => strtoupper($this->faker->bothify('####-???')),
            'marca' => $marca,
            'modelo' => $modelo,
            'kilometraje' => $this->faker->numberBetween(0, 200000),
            'nota' => $this->faker->randomFloat(1, 1, 5),
        ];
    }

    public function forTest(): static{
        return $this->state(function () {
            return [
                'id_usuario_propietario' => User::factory(),
            ];
        });
    }
}
