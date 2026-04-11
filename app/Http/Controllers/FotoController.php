<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caravana;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function store(Request $request, Caravana $caravana){
        if ($caravana->id_usuario_propietario !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'fotos' => 'required',
            'fotos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('fotos')) {

        $manager = new ImageManager(new Driver());
        $principalAsignada = Foto::where('id_caravana', $caravana->id)->where('es_principal', true)->exists();

            foreach ($request->file('fotos') as $index => $file) {

                $filename = uniqid().'_'.$caravana->id.'.webp';

                $image = $manager->read($file)->cover(800, 600)->toWebp(95);

                $image->save(storage_path('app/public/imagenes-caravanas/'.$filename));


                Foto::create([
                    'id_caravana' => $caravana->id,
                    'url' => '/storage/imagenes-caravanas/'.$filename,
                    'es_principal' => !$principalAsignada
                ]);

                $principalAsignada = true;
            }
        }

        if ($request->input('back')) {
            return back()->with('success', 'Fotos subidas');
        }else{
            return redirect()->route('profile')->with('success','Fotos subidas con exito');
        }
    }



    public function destroy(Foto $foto){
        if ($foto->caravana->id_usuario_propietario !== auth()->id()){
            abort(403);
        }

        if($foto->es_principal){
            $nuevaPrincipal = Foto::where('id_caravana', $foto->id_caravana)->where('id', '!=', $foto->id)->first();

            if($nuevaPrincipal){
                Foto::where('id_caravana', $foto->id_caravana)->update(['es_principal' => false]);

                $nuevaPrincipal->update(['es_principal' => true]);
            }
        }

        $foto->borrar();

        return back()->with('success','Foto eliminada');
    }


    public function setMain(Foto $foto){
        Foto::where('id_caravana', $foto->id_caravana)->update(['es_principal' => false]);

        $foto->update(['es_principal' => true]);

        return back();
    }

    public function create(Caravana $caravana){
        if ($caravana->id_usuario_propietario !== auth()->id()) {
            abort(403);
        }

        return view('profile.formFotos', compact('caravana'));
    }
}
