<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GarderoberResource extends JsonResource
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
            'opis' => $this->opis,
            'user' => new UserResource($this->whenLoaded('user')), // Celi korisnik umesto user_id
            'odeca' => OdecaResource::collection($this->whenLoaded('odeca')), // Kolekcija odeće
        ];
    }
}
