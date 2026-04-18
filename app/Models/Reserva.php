<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
            Reserva::where('id_anuncio', $this->id_anuncio)->where('id', '!=', $this->id)->where('estado', 'pendiente')
                ->where(function($query){
                    $query->whereBetween('fecha_inicio', [$this->fecha_inicio, $this->fecha_fin])
                        ->orWhereBetween('fecha_fin', [$this->fecha_inicio, $this->fecha_fin])
                        ->orWhere(function($q){
                            $q->where('fecha_inicio', '<=', $this->fecha_inicio)
                            ->where('fecha_fin', '>=', $this->fecha_fin);
                        });
                })->update(['estado' => 'cancelada']);
        }
    }

    public static function calcularCoste($anuncio, $inicio, $fin){
        $dias = $inicio->diffInDays($fin) + 1;
        return $dias * $anuncio->precio_dia;
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
