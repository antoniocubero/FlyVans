<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'fecha_inicio' => $this->fecha_inicio ? $this->fecha_inicio->format('d/m/Y') : null,

            'fecha_fin' => $this->fecha_fin ? $this->fecha_fin->format('d/m/Y') : null,

            'estado' => Str::ucfirst($this->estado),

            'caravana' => Str::title(optional($this->anuncio->caravana)->marca . ' ' .optional($this->anuncio->caravana)->modelo),

            'coste' => $this->coste,

            'foto_principal' => $this->anuncio->caravana->foto_principal_url,

            'valoracion_id_reserva' => optional($this->valoracion)->id,

            'valoracion_puntuacion' => optional($this->valoracion)->puntuacion,
        ];
    }
}
