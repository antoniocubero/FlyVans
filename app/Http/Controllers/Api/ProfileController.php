<?php

namespace App\Http\Controllers\Api;

use App\Models\Reserva;
use App\Models\Anuncio;
use App\Http\Controllers\Controller;
use App\Http\Resources\CaravanaResource;
use App\Http\Resources\AnuncioResource;
use App\Http\Resources\ReservaResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function listarCaravanas(){
        $user = auth()->user();

        $caravanas = $user->caravanas()->with('fotoPrincipal')->latest()->get();

        return response()->json([
            'title' => 'Caravanas',
            'vans' => CaravanaResource::collection($caravanas),
        ]);
    }


    public function listarAnuncios(){
        $anuncios = Anuncio::with('caravana')->whereHas('caravana', 
            function ($query) {
                $query->where('id_usuario_propietario', auth()->id());
            })->latest()->get();

        return response()->json([
            'title' => 'Anuncios',
            'ads' => AnuncioResource::collection($anuncios),
        ]);
    }

    public function listarReservasArrendador(){
        $reservas = Reserva::with([
                'anuncio' => fn($q) => $q->withTrashed(),
                'anuncio.caravana' => fn($q) => $q->withTrashed()
            ])->whereHas('anuncio.caravana', 
                function ($query) {
                    $query->withTrashed()
                        ->where('id_usuario_propietario', auth()->id());
                })->latest()->get();

        return response()->json([
            'title' => 'Reservas',
            'bookings' => ReservaResource::collection($reservas),
        ]);
    }

    public function listarReservasArrendatario(){
        $reservas = Reserva::with([
                'anuncio' => fn($q) => $q->withTrashed(),
                'anuncio.caravana' => fn($q) => $q->withTrashed(),
                'valoracion'
            ])->where('id_usuario_reserva', auth()->id())->latest()->get();

        return response()->json([
            'title' => 'Reservas',
            'bookings' => ReservaResource::collection($reservas),
        ]);
    }
}
