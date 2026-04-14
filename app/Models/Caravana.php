<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caravana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'caravanas';

    protected $fillable = [
        'id_usuario_propietario',
        'matricula',
        'marca',
        'modelo',
        'kilometraje',
        'nota',
    ];

    protected static function boot(){
        parent::boot();
        static::deleting(function ($caravana) {
            foreach ($caravana->anuncios as $anuncio) {
                $anuncio->delete();
            }
        });
    }

    protected $casts = ['nota' => 'float'];

    protected $appends = ['foto_principal_url'];

    // Relación: una caravana pertenece a un usuario (propietario)
    public function propietario()
    {
        return $this->belongsTo(User::class, 'id_usuario_propietario');
    }

    // Relacion: una caravana puede tener muchos anuncios
    public function anuncios(){
        return $this->hasMany(Anuncio::class, 'id_caravana');
    }

    // Relacion: una caravana puede tener muchas fotos
    public function fotos(){
        return $this->hasMany(Foto::class, 'id_caravana');
    }

    public function fotoPrincipal(){
        
        return $this->hasOne(Foto::class, 'id_caravana')
                    ->where('es_principal', true);
    }

    public function getFotoPrincipalUrlAttribute(){
        if ($this->fotoPrincipal) {
            return $this->fotoPrincipal->url;
        }

        return asset('/images/default-img.jpg');
    }

    public function valoraciones(){
        return Valoracion::whereHas('reserva.anuncio', function ($query) {
            $query->where('id_caravana', $this->id)
                ->withTrashed();
        });
    }

    public function fechasOcupadas(){
        $this->loadMissing([
            'anuncios' => function ($query) {
                $query->withTrashed();
            },
            'anuncios.reservas'
        ]);

        return $this->anuncios->pluck('reservas')->flatten()->where('estado', 'confirmada')->flatMap(function ($reserva) {

                $fechas = [];

                $inicio = $reserva->fecha_inicio->copy();
                $fin = $reserva->fecha_fin->copy();

                while ($inicio <= $fin) {
                    $fechas[] = $inicio->format('Y-m-d');
                    $inicio->addDay();
                }

                return $fechas;
            })->unique()->values();
    }
}
