<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caravana;
use App\Models\Anuncio;


class MainController extends Controller
{
    public function searchDefault(Request $request){
        $anuncios = Anuncio::paginate(20);

        return view('search')->with('anuncios', $anuncios);

    }

    public function showAd(Anuncio $anuncio){

        $fechasOcupadas = $anuncio->caravana->fechasOcupadas();

        $valoraciones = $anuncio->caravana->valoraciones()->get();

        return view('ad', compact('anuncio', 'fechasOcupadas', 'valoraciones'));
    }
}
