<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Anuncios;
use App\Http\Controllers\Api\ProfileController;


Route::get('/cargar-anuncios', [Anuncios::class, 'cargarAnuncios']);

Route::get('/cargar-marcas', [Anuncios::class, 'cargarMarcas']);
Route::get('/cargar-localizaciones', [Anuncios::class, 'cargarLocalizaciones']);

