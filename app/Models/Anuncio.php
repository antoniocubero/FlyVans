<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Anuncio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anuncios';

    
    protected $fillable = [
        'id_caravana',
        'titulo',
        'descripcion',
        'precio_dia',
        'estado',
        'localizacion',
    ];

    protected static function boot(){
        parent::boot();

        static::deleting(function ($anuncio) {
            foreach ($anuncio->reservas as $reserva) {
                if ($reserva->estado === 'pendiente') {
                    $reserva->cancelar();
                }
            }
        });
    }

    protected function titulo(): Attribute{
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
    }

    protected function localizacion(): Attribute{
        return Attribute::make(
            set: fn ($value) => ucwords(strtolower($value)),
            get: fn ($value) => ucwords($value),
        );
    }

    // Relación: un anuncio pertenece a una caravana
    public function caravana()
    {
        return $this->belongsTo(Caravana::class, 'id_caravana')->withTrashed();
    }


    public function reservas(){
        return $this->hasMany(Reserva::class, 'id_anuncio');
    }

    public function valoraciones(){
        return $this->hasManyThrough(
            Valoracion::class,
            Reserva::class,
            'id_anuncio',// FK en reservas
            'id_reserva',// FK en valoraciones
            'id',// PK en anuncios
            'id'// PK en reservas
        );
    }
}
