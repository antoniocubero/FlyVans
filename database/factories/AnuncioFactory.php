<?php

namespace Database\Factories;

use App\Models\Caravana;
use App\Models\User;
use App\Models\Anuncio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anuncio>
 */
class AnuncioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_caravana' => Caravana::inRandomOrder()->first()->id,
            'titulo' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'precio_dia' => $this->faker->randomFloat(2, 10, 100),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
            'localizacion' => $this->faker->city(),
        ];
    }
}
