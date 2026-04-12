<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Anuncio;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $nombre = $request->user()->name;
        if(str_contains($nombre, ' ')){
            $nombre = explode(' ', $nombre)[0];
        }

        return view('profile.profile', [
            'user' => $request->user(),
            'nombre' => $nombre
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        foreach ($user->reservas as $reserva) {
            $reserva->cancelar();
        }
        
        foreach ($user->caravanas as $caravana) {
            foreach ($caravana->anuncios as $anuncio) {
                $anuncio->delete();
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
