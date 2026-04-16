<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caravana;
use App\Models\Foto;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{

        Foto::query()->delete();
        
        $rutaBase = storage_path('app/public/caravanas');

        $carpetas = File::directories($rutaBase);

        $caravanas = Caravana::all();

        foreach ($caravanas as $caravana) {

            $carpetaPath = collect($carpetas)->random();

            $imagenes = File::files($carpetaPath);

            $manager = new ImageManager(new Driver());

            foreach ($imagenes as $imagen) {

                $nombreArchivo = $imagen->getFilename();

                $nuevoNombre = uniqid() . '_' . $nombreArchivo;

                $rutaDestino = "imagenes-caravanas/{$nuevoNombre}";

                $img = $manager->read($imagen->getPathname())
                    ->cover(800, 600)
                    ->toWebp(80);

                Storage::disk('public')->put($rutaDestino, $img);

                Foto::create([
                    'id_caravana' => $caravana->id,
                    'url' => "/storage/{$rutaDestino}",
                    'es_principal' => $nombreArchivo === 'main.webp',
                ]);
            }
        }
    }
}
