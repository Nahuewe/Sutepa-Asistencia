<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'votacion_id' => $this->resource->votacion_id,
            'asistente_id' => $this->resource->asistente_id,
            'respuesta' => $this->resource->respuesta
        ];
    }
}
