<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Caravana;
use App\Models\Anuncio;
use App\Models\Reserva;
use App\Models\Valoracion;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(1000)->create();
        Caravana::factory(200)->create();
        $this->call(FotoSeeder::class);
        Anuncio::factory(80)->create();
        Reserva::factory(300)->create();


        $reservas = Reserva::where('estado', 'confirmada')
            ->where('fecha_fin', '<', now())
            ->doesntHave('valoracion')
            ->get();


        foreach ($reservas as $reserva) {
            Valoracion::factory()->create([
                'id_reserva' => $reserva->id,
            ]);
        }

        Caravana::all()->each(function ($caravana) {
            $media = Valoracion::whereHas('reserva.anuncio', function ($query) use ($caravana) {
                $query->where('id_caravana', $caravana->id);
            })->avg('puntuacion');

            $caravana->update(['nota' => $media]);
        });
    }
}
