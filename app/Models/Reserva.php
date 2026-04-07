<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'id_usuario_reserva',
        'id_anuncio',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'coste',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function cancelar(){
        if($this->estado == 'pendiente'){
            $this->estado = 'cancelada';
            $this->save();
        }
    }

    public function aceptar(){
        if($this->estado == 'pendiente'){
            $this->estado = 'confirmada';
            $this->save();
        }
    }

    // Relaciones
    public function anuncio(){
        return $this->belongsTo(Anuncio::class, 'id_anuncio')->withTrashed();;
    }

    public function valoracion(){
        return $this->hasOne(Valoracion::class, 'id_reserva');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_usuario_reserva');
    }
}
