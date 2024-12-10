<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'ime' => $this->ime,
            'prezime' => $this->prezime,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'datum_rodjenja' => $this->datum_rodjenja,
            'telefon' => $this->telefon,
            'adresa' => $this->adresa,
            'biografija' => $this->biografija,
        
        ];
    }
}
