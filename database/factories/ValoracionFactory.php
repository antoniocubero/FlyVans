<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reserva;
use App\Models\Valoracion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Valoracion>
 */
class ValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_reserva' => Reserva::inRandomOrder()->first()->id,
            'puntuacion'=>$this->faker->numberBetween(1, 5),
            'comentario'=>$this->faker->sentence(),
            'fecha'=>$this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
