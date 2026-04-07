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

        $fechasOcupadas = $anuncio->reservas
            ->where('estado', 'confirmada')
            ->flatMap(function ($reserva) {

                $fechas = [];

                $inicio = $reserva->fecha_inicio->copy();
                $fin = $reserva->fecha_fin->copy();

                while ($inicio <= $fin) {
                    $fechas[] = $inicio->format('Y-m-d');
                    $inicio->addDay();
                }

                return $fechas;
            })
            ->values();

        return view('ad', compact('anuncio', 'fechasOcupadas'));
    }
}
