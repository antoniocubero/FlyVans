<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Caravana;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnuncioController extends Controller
{
    public function update(Request $request, Anuncio $anuncio){
        //dd($anuncio);
        if ($anuncio->caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'precio_dia' => 'required|decimal:0,2|min:0',
            'localizacion' => 'required|string|max:100',
            'id_caravana' => [
                'required',
                'integer',
                Rule::exists('caravanas', 'id')->where('id_usuario_propietario', auth()->id())
            ]
        ]);

        $anuncio->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'precio_dia' => $request->precio_dia,
            'localizacion' => $request->localizacion,
            'id_caravana' => $request->id_caravana
        ]);

        return back()->with('success', 'Datos actualizados');
    }

    public function create(){
        $caravanas = auth()->user()->caravanas()->get();

        return view('profile.formNewAd')->with('caravanas',$caravanas);
    }

    public function store(Request $request){
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'precio_dia' => 'required|decimal:0,2|min:0',
            'localizacion' => 'required|string|max:100',
            'id_caravana' => [
                'required',
                'integer',
                Rule::exists('caravanas', 'id')->where('id_usuario_propietario', auth()->id())
            ]
        ]);

        $anuncio = Anuncio::create([
            'titulo' => strtolower($request->titulo),
            'descripcion' => $request->descripcion,
            'precio_dia' => $request->precio_dia,
            'localizacion' => strtolower($request->localizacion),
            'id_caravana' => $request->id_caravana
        ]);

        return redirect()->route('profile')->with('success', 'Anuncio creado');
    }

    public function destroy(Request $request, Anuncio $anuncio){
        //dd($anuncio->caravana);
        if (! $anuncio->caravana || $anuncio->caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $anuncio->delete();
        
        return redirect()->route('profile')->with('success','Anuncio eliminado');
    }

    public function edit(Anuncio $anuncio){
        $anuncio = Anuncio::with('caravana')
            ->where('id', $anuncio->id)
            ->whereHas('caravana', fn($q) =>
                $q->where('id_usuario_propietario', auth()->id())
            )->firstOrFail();

        $caravanas = auth()->user()->caravanas;

        return view('profile.editAd', compact('anuncio', 'caravanas'));
    }
}
