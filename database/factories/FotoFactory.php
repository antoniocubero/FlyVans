<?php

namespace Database\Factories;

use App\Models\Foto;
use App\Models\Caravana;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Foto>
 */
class FotoFactory extends Factory
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
            'url' => 'https://placehold.co/800x600?text=Caravana+' . $this->faker->word(),
            'es_principal' => false,
        ];
    }
}
