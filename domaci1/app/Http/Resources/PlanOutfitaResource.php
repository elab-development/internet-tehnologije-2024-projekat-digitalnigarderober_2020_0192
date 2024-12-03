<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanOutfitaResource extends JsonResource
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
            'datum' => $this->datum,
            'lokacija' => $this->lokacija,
            'vremenska_prognoza' => $this->vremenska_prognoza,
            'dogadjaj' => $this->dogadjaj,
            'user' => new UserResource($this->whenLoaded('user')), // Celi korisnik umesto user_id
            'odeca' => OdecaResource::collection($this->whenLoaded('odeca')), // Kolekcija odeće povezana sa planom outfita
        ];
    }
}
