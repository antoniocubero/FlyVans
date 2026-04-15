<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaravanaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\Api\ProfileController as ApiProfileController;


Route::get('/', fn() => view('index'))->name('home');
Route::get('/home', fn() => view('index'));

Route::get('/search', [MainController::class, 'searchDefault'])->name('search');
Route::get('/ad/{anuncio}', [MainController::class, 'showAd'])->name('ad.show');

Route::get('/cookies', fn()=>view('info.cookies'))->name('cookies');
Route::get('/privacy', fn()=>view('info.privacy'))->name('privacy');
Route::get('/how-rent', fn()=>view('info.how-rent'))->name('how-rent');
Route::get('/how-publish', fn()=>view('info.how-publish'))->name('how-publish');


Route::middleware('auth')->group(function () {

    //PERFIL
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');



    //CARAVANAS
    Route::get('/profile/van/new', fn() => view('profile.formNewVan'))->name('profile.formNewVan');

    Route::post('/profile/van/new', [CaravanaController::class, 'store'])->name('vans.store');
    Route::put('/profile/van/{caravana}', [CaravanaController::class, 'update'])->name('vans.update');
    Route::delete('/profile/van/{caravana}', [CaravanaController::class, 'destroy'])->name('vans.destroy');

    Route::get('/profile/van/{caravana}/edit', [CaravanaController::class, 'edit'])->name('vans.edit');



    //FOTOS
    Route::get('/profile/van/{caravana}/fotos', [FotoController::class, 'create'])->name('photos.create');
    Route::post('/profile/van/{caravana}/fotos', [FotoController::class, 'store'])->name('photos.store');

    Route::delete('/fotos/{foto}', [FotoController::class, 'destroy'])->name('photos.destroy');
    Route::post('/fotos/{foto}/principal', [FotoController::class, 'setMain'])->name('photos.main');



    //ANUNCIOS
    Route::get('/profile/ad/new', [AnuncioController::class, 'create'])->name('ads.create');
    Route::post('/profile/ad/new', [AnuncioController::class, 'store'])->name('ads.store');

    Route::get('/profile/ad/{anuncio}/edit', [AnuncioController::class, 'edit'])->name('ads.edit');
    Route::put('/profile/ad/{anuncio}', [AnuncioController::class, 'update'])->name('ads.update');
    Route::delete('/profile/ad/{anuncio}', [AnuncioController::class, 'destroy'])->name('ads.destroy');



    //RESERVAS
    Route::post('/booking/new', [ReservaController::class, 'store'])->name('booking.store');

    Route::get('/profile/booking/{reserva}', [ReservaController::class, 'show'])->name('booking.show');

    Route::post('/profile/booking/{reserva}/cancel', [ReservaController::class, 'cancel'])->name('booking.cancel');
    Route::post('/profile/booking/{reserva}/accept', [ReservaController::class, 'accept'])->name('booking.accept');


    //VALORACIONES
    Route::get('/rating/{reserva}/new', [ValoracionController::class, 'create'])->name('rating.create');
    Route::post('/rating/{reserva}', [ValoracionController::class, 'store'])->name('rating.store');


    //API
    Route::get('/api/profile/vans', [ApiProfileController::class, 'listarCaravanas']);
    Route::get('/api/profile/ads', [ApiProfileController::class, 'listarAnuncios']);
    Route::get('/api/profile/bookings-r', [ApiProfileController::class, 'listarReservasArrendador']);
    Route::get('/api/profile/bookings-o', [ApiProfileController::class, 'listarReservasArrendatario']);
});


require __DIR__.'/auth.php';