<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Anuncio;



class ReservaController extends Controller
{
    public function cancelBooking(Request $request, Reserva $reserva){
        if ($reserva->id_usuario_reserva !== auth()->id() && $reserva->anuncio->caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $reserva->cancelar();

        return back()->with('success','Reserva cancelada');
    }

    public function acceptBooking(Request $request, Reserva $reserva){
        if ($reserva->anuncio->caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $reserva->aceptar();

        return back()->with('success','Reserva aceptada');
    }

    public function viewBooking(Request $request, Reserva $reserva){
        if ($reserva->id_usuario_reserva !== auth()->id() && $reserva->anuncio->caravana->id_usuario_propietario !== auth()->id()) {
            abort(404);
        }

        $propietario = ($reserva->anuncio->caravana->id_usuario_propietario == auth()->id());

        $yaValorada = $reserva->valoracion != null;

        $puedeCancelar = !$propietario && $reserva->estado == 'pendiente';
        $puedeAceptar = $propietario && $reserva->estado == 'pendiente';
        $puedeValorar = !$propietario && !$yaValorada && $reserva->estado == 'aceptada' && $reserva->fecha_fin < now();


        return view('profile.booking')->with([
            'propietario' => $propietario,
            'reserva' => $reserva,
            'puedeCancelar' => $puedeCancelar,
            'puedeAceptar' => $puedeAceptar,
            'puedeValorar' => $puedeValorar,]);
    }

    public function createBooking(Request $request){
        $request->validate([
            'fechas' => 'required',
            'id_anuncio' => 'required|exists:anuncios,id',
        ]);

        [$fechaInicio, $fechaFin] = explode('|', $request->fechas);

        $fechaInicio = \Carbon\Carbon::parse($fechaInicio);
        $fechaFin = \Carbon\Carbon::parse($fechaFin);

        $anuncio = Anuncio::findOrFail($request->id_anuncio);

        if ($anuncio->caravana->id_usuario_propietario == auth()->id()) {
            return back()->withErrors([
                'reserva' => 'No puedes reservar tu propia caravana'
            ]);
        }
        
        $existeConflicto = $anuncio->reservas()
            ->where('estado', 'confirmada')
            ->where(function($query) use ($fechaInicio, $fechaFin){
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                    ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                    ->orWhere(function($q) use ($fechaInicio, $fechaFin){
                        $q->where('fecha_inicio', '<=', $fechaInicio)
                            ->where('fecha_fin', '>=', $fechaFin);
                    });
            })
            ->exists();

        if($existeConflicto){
            return back()->withErrors(['fechas' => 'Fechas no disponibles']);
        }


        $dias = $fechaInicio->diffInDays($fechaFin) + 1;
        $total = $dias * $anuncio->precio_dia;

        Reserva::create([
            'id_usuario_reserva' => auth()->id(),
            'id_anuncio' => $anuncio->id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => 'pendiente',
            'coste' => $total,
        ]);

        return redirect()->route('home')->with('success', 'Reserva creada');
    }
}
