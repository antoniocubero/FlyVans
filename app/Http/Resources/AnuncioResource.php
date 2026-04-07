<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class AnuncioResource extends JsonResource
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
            'titulo' => Str::title($this->titulo),
            'caravana' => $this->caravana ? Str::title($this->caravana->marca . ' ' . $this->caravana->modelo) : null,
            'precio_dia' => $this->precio_dia,
            'foto_principal' => $this->caravana->foto_principal_url,
        ];
    }
}
