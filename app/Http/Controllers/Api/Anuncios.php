<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anuncio;

class Anuncios extends Controller
{
    function index(){
        return response()->json(['mensaje' => 'Api funcionandooo']);
    }

    function cargarAnuncios(Request $request){

        $pagina = $request->get('page', 1);
        $cantidad = 10;

        $query = Anuncio::with('caravana.fotoPrincipal')->where('estado', 'activo');

        if ($request->has('brands')) {
            $query->whereHas('caravana', function($q) use ($request) {
                $q->whereIn('marca', $request->brands);
            });
        }

        if ($request->filled('localizacion')) {
            $query->where('localizacion', $request->localizacion);
        }

        if ($request->filled('orden')) {
            switch ($request->orden) {
                case 'precio-asc':
                    $query->orderBy('precio_dia', 'asc');
                    break;
                case 'precio-desc':
                    $query->orderBy('precio_dia', 'desc');
                    break;
            }
        }

        $data = $query->paginate($cantidad, ['*'], 'page', $pagina);

        return response()->json($data);
    }

    function cargarMarcas(Request $request){
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 3);

        $marcas = Anuncio::join('caravanas', 'anuncios.id_caravana', '=', 'caravanas.id')
            ->where('anuncios.estado', 'activo')
            ->select('caravanas.marca')
            ->distinct()
            ->skip($offset)
            ->take($limit)
            ->pluck('marca');

        return response()->json($marcas);
    }

    function cargarLocalizaciones(Request $request){
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 5);

        $localizaciones = Anuncio::where('estado', 'activo')
            ->select('localizacion')
            ->distinct()
            ->skip($offset)
            ->take($limit)
            ->pluck('localizacion')
            ->map(function ($item) {
                return ucfirst($item);
            });;

        return response()->json($localizaciones);
    }
}