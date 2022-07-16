<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GejalaGrupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->nama_gejala_grup,
            'urutan' => $this->urutan,
            'data' => $this->gejala,
        ];
    }
}
