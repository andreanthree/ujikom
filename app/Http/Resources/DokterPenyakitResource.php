<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DokterPenyakitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['foto'] = url($data['foto']);
        $data['nama_kategori'] = $data['dokter']['kategori']['nama_kategori'];
        unset($data['dokter']);
        return $data;
    }
}
