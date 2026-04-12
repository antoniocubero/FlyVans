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
        $puntuacion = $this->faker->numberBetween(1, 5);

        $comentariosPorPuntuacion = [
            1 => ['Muy mala experiencia, no repetiría.', 'La caravana estaba en mal estado.'],
            2 => ['Experiencia regular, mejorable.', 'No estaba como esperaba.'],
            3 => ['Correcto, sin más.', 'Aceptable pero mejorable.'],
            4 => ['Muy buena experiencia, recomendable.', 'Todo bastante bien.'],
            5 => ['Experiencia perfecta, repetiré seguro.', 'Todo impecable.'],
        ];

        return [
            'puntuacion' => $puntuacion,
            'comentario' => $this->faker->randomElement($comentariosPorPuntuacion[$puntuacion]),
            'fecha' => now(),
        ];
    }
}
