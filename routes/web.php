<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaravanaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\Api\ProfileController as ApiProfileController;





Route::get('/', function () {
    return view('index');
});

Route::get('/home', function () {
    return view('index');
})->name('home');

Route::get('/search', [MainController::class, 'searchDefault'])->name('search');

Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::get('/ad/{anuncio}', [MainController::class, 'showAd']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'edit']);

    Route::patch('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');

    Route::delete('/fotos/{foto}', [FotoController::class, 'destroyFoto'])->name('fotos.destroy');
    Route::post('/fotos/{foto}/principal', [FotoController::class, 'principal'])->name('fotos.principal');


    Route::get('/profile/van/{caravana}/fotos', [FotoController::class, 'formFotos'])->name('fotos.create');
    Route::post('/profile/van/{caravana}/fotos', [FotoController::class, 'storeFotos'])->name('fotos.store');


    Route::post('/profile/van/new', [CaravanaController::class, 'newVan'])->name('newVan');

    Route::post('/profile/van/{caravana}/edit', [CaravanaController::class, 'editVan'])->name('editVan');

    Route::delete('/profile/van/{caravana}', [CaravanaController::class, 'deleteVan']);

    Route::post('/profile/ad/new/', [AnuncioController::class, 'newAd'])->name('newAd');

    Route::post('/profile/ad/{anuncio}/edit', [AnuncioController::class, 'editAd'])->name('editAd');

    Route::delete('/profile/ad/{anuncio}', [AnuncioController::class, 'deleteAd']);

    Route::post('/booking/new', [ReservaController::class, 'createBooking'])->name('booking.new');

    Route::post('/profile/booking/{reserva}/cancel', [ReservaController::class, 'cancelBooking']);

    Route::post('/profile/booking/{reserva}/accept', [ReservaController::class, 'acceptBooking']);

    Route::get('/profile/booking/{reserva}', [ReservaController::class, 'viewBooking']);



    Route::get('/profile/van/{caravana}/edit', [ProfileController::class, 'editVan'])->name('profile.editVan');

    Route::get('/profile/van/new', function () {
        return view('profile.formNewVan');
    })->name('profile.formNewVan');

    Route::get('/profile/ad/{anuncio}/edit', [ProfileController::class, 'editAd'])->name('profile.editAd');

    Route::get('/profile/ad/new', [AnuncioController::class, 'formNewAd'])->name('profile.formNewAd');


    Route::get('/rating/{reserva}/new', [ValoracionController::class, 'ratingForm']);
    Route::post('/rating/{reserva}', [ValoracionController::class, 'newRating'])->name('rating.store');


    //API 
    Route::get('/api/profile/vans', [ApiProfileController::class, 'listarCaravanas']);
    Route::get('/api/profile/ads', [ApiProfileController::class, 'listarAnuncios']);
    Route::get('/api/profile/bookings-r', [ApiProfileController::class, 'listarReservasArrendador']);
    Route::get('/api/profile/bookings-o', [ApiProfileController::class, 'listarReservasArrendatario']);
});




require __DIR__.'/auth.php';

