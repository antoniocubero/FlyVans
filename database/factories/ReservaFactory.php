<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Caravana;
use App\Models\User;
use App\Models\Anuncio;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anuncio = Anuncio::with('caravana')->inRandomOrder()->first();

        if (!$anuncio) { //para tests
            return [
                'id_usuario_reserva' => User::factory(),
                'id_anuncio' => Anuncio::factory(),
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addDays(3),
                'estado' => 'pendiente',
                'coste' => 100,
            ];
        }


        $propietarioId = $anuncio->caravana->id_usuario_propietario;

        $usuarioReserva = User::where('id', '!=', $propietarioId)
            ->inRandomOrder()
            ->first();

        $estado = $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']);

        if ($estado === 'pendiente') {
            $fechaInicio = $this->faker->dateTimeBetween('now', '+3 months');
        } else {
            $fechaInicio = $this->faker->dateTimeBetween('-8 months', '+3 months');
        }

        $diasReserva = $this->faker->numberBetween(2, 5);
        $fechaFin = Carbon::parse($fechaInicio)->addDays($diasReserva);

        $coste = $anuncio->precio_dia * $diasReserva;

        if (!$usuarioReserva || !$anuncio) {
            return [];
        }

        return [
            'id_usuario_reserva' => $usuarioReserva->id,
            'id_anuncio' => $anuncio->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
            'coste' => $coste,
        ];
    }

    public function forTest(): static
    {
        return $this->state(function () {

            $anuncio = Anuncio::factory()->forTest()->create();

            return [
                'id_usuario_reserva' => User::factory(),
                'id_anuncio' => $anuncio->id,
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addDays(3),
                'estado' => 'pendiente',
                'coste' => $anuncio->precio_dia * 3,
            ];
        });
    }
}
