<?php

namespace App\Http\Controllers;

use App\Models\Caravana;
use App\Models\Anuncio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;

class CaravanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function update(Request $request, Caravana $caravana){
        if ($caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $request->validate([
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'kilometros' => 'required|integer|min:0',
            'matricula' => [
                'required',
                'string',
                'max:20',
                'unique:caravanas,matricula',
                'regex:/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/i'
            ],
        ], [
            'matricula.regex' => 'La matrícula debe tener el formato 0000XXX (4 números y 3 letras sin vocales).',
        ]);

        $caravana->update([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'kilometraje' => $request->kilometros,
            'matricula' => $request->matricula
        ]);

        return back()->with('success', 'Datos actualizados');
    }

    public function store(Request $request){
        $request->validate([
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'kilometros' => 'required|integer|min:0',
            'matricula' => [
                'required',
                'string',
                'max:20',
                'unique:caravanas,matricula',
                'regex:/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/i'
            ],
        ], [
            'matricula.regex' => 'La matrícula debe tener el formato 0000XXX (4 números y 3 letras sin vocales).',
        ]);

        $caravana = Caravana::create([
            'id_usuario_propietario' => auth()->id(),
            'matricula' => $request->matricula,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'kilometraje' => $request->kilometros
        ]);

        return redirect()->route('photos.create', $caravana->id);
    }

    public function destroy(Request $request, Caravana $caravana){
        if ($caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $fotos = $caravana->fotos;

        foreach ($fotos as $foto) {
            $foto->borrar();
        }

        $anuncios = $caravana->anuncios();
        foreach ($anuncios as $anuncio) {
            $anuncio->delete();
        }

        $caravana->delete();
        
        return redirect()->route('profile')->with('success','Caravana eliminada');
    }

    public function edit($id){
        $caravana = auth()->user()->caravanas()->findOrFail($id);
        $fotos = $caravana->fotos;

        return view('profile.editVan', compact('caravana', 'fotos'));
    }
}
