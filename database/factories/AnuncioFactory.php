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

        $titulos = [
            'Escapada en caravana totalmente equipada',
            'Camper perfecta para viajar por España',
            'Alquiler de caravana lista para ruta',
            'Viaja con comodidad y libertad',
        ];

        $descripciones = [
            'Caravana totalmente equipada, ideal para escapadas en pareja o familia.',
            'Incluye cocina, cama, almacenamiento y todo lo necesario para viajar cómodo.',
            'Perfecta para rutas por montaña o costa, muy fácil de conducir.',
            'Vehículo revisado y listo para disfrutar sin preocupaciones.',
        ];

        $ciudades = [
            'Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Málaga',
            'Granada', 'Bilbao', 'Zaragoza', 'Alicante', 'Córdoba'
        ];

        $base = $this->faker->numberBetween(50, 150);
        $decimales = $this->faker->randomElement([0, 0.5, 0.99]);

        return [
            'id_caravana' => Caravana::doesntHave('anuncios')->inRandomOrder()->first()?->id,
            'titulo' => $this->faker->randomElement($titulos),
            'descripcion' => $this->faker->randomElement($descripciones),
            'precio_dia' => $base + $decimales,
            'estado' => 'activo',
            'localizacion' => $this->faker->randomElement($ciudades),
        ];
    }

    public function forTest(): static
    {
        return $this->state(function () {
            return [
                'id_caravana' => Caravana::factory(),
            ];
        });
    }
}
