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
        $propietarioId = $anuncio->caravana->id_usuario_propietario;

        $usuarioReserva = User::where('id', '!=', $propietarioId)
            ->inRandomOrder()
            ->first();

        $fechaInicio = $this->faker->dateTimeBetween('-6 months', '-5 days');
        $diasReserva = $this->faker->numberBetween(2, 3);
        $fechaFin = Carbon::parse($fechaInicio)->addDays($diasReserva);

        $coste = $anuncio->precio_dia * $diasReserva;

        return [
            'id_usuario_reserva' => $usuarioReserva->id,
            'id_anuncio' => $anuncio->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
            'coste' => $coste,
        ];
    }
}
