<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Valoracion;
use App\Models\Reserva;


class ValoracionController extends Controller
{
    public function ratingForm(Reserva $reserva){
        if ($reserva->id_usuario_reserva !== auth()->id()) {
            abort(404);
        }

        if ($reserva->valoracion) {
            return redirect()->back()->with('error', 'Esta reserva ya tiene una valoración');
        }

        if ($reserva->estado !== 'confirmada' || now()->lt($reserva->fecha_fin)) {
            return redirect()->back()->with('error', 'Aún no puedes valorar esta reserva');
        }

        return view('auth.ratingForm', ['reserva' => $reserva]);
    }

    public function newRating(Request $request, Reserva $reserva){
        if ($reserva->id_usuario_reserva !== auth()->id()) {
            abort(404);
        }

        if ($reserva->valoracion) {
            return redirect()->back()->with('error', 'Esta reserva ya tiene una valoración');
        }

        if ($reserva->estado !== 'confirmada' || now()->lt($reserva->fecha_fin)) {
            return redirect()->back()->with('error', 'Aún no puedes valorar esta reserva');
        }

        $request->validate([
            'puntuacion' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:500'],
        ]);

        $reserva->valoracion()->create([
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
            'fecha' => now(),
        ]);

        return redirect('/profile')->with('success', 'Valoración enviada correctamente');
    }
}
