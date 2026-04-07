<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caravana;
use App\Models\Foto;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Caravana::all()->each(function ($caravana) {

            // Crear 1 foto principal
            Foto::factory()->create([
                'id_caravana' => $caravana->id,
                'es_principal' => true,
            ]);

            // Crear 3 fotos secundarias
            Foto::factory(3)->create([
                'id_caravana' => $caravana->id,
                'es_principal' => false,
            ]);
        });
    }
}
