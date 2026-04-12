<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'id_reserva',
        'puntuacion',
        'comentario',
        'fecha',
    ];

    // Relación: un anuncio pertenece a una caravana
    public function reserva(){
        return $this->belongsTo(Reserva::class, 'id_reserva');
    }

    protected function fecha(): Attribute{
        return Attribute::make(
            get: fn ($value) => $value 
                ? Carbon::parse($value)->format('d-m-Y') 
                : null,
        );
    }

    public function actualizarPuntuacion(){
        $caravana = $this->reserva?->anuncio?->caravana;

        if (!$caravana) return;

        $media = Valoracion::whereHas('reserva.anuncio', function ($query) use ($caravana) {
            $query->where('id_caravana', $caravana->id);
        })->avg('puntuacion');

        $caravana->nota = $media ?? 0;
        $caravana->save();
    }

    protected static function booted(){
        static::saved(function ($valoracion) {
            $valoracion->actualizarPuntuacion();
        });

        static::deleted(function ($valoracion) {
            $valoracion->actualizarPuntuacion();
        });
    }
}
