<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OdecaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'naziv' => $this->naziv,
            'tip' => $this->tip,
            'boja' => $this->boja,
            'sezona' => $this->sezona,
            'materijal' => $this->materijal,
            'slika' => $this->slika,
        ];
    }
}
