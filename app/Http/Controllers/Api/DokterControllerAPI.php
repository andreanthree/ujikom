<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DokterPenyakitResource;
use App\Http\Resources\GejalaGrupResource;
use App\Models\MAturan;
use App\Models\MDokter;
use App\Models\MDokterPenyakit;
use App\Models\MGejala;
use App\Models\MGejalaGrup;
use Illuminate\Http\Request;

class DokterControllerAPI extends Controller
{

    public function getdokter(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $kode_penyakit = $request->kode_penyakit;
        $hariini = Helper::hari_ini();
        $data = DokterPenyakitResource::collection(
            MDokterPenyakit::where('kode_penyakit', $kode_penyakit)
                ->with('dokter.kategori')
                ->leftjoin('dokter', 'dokter.kode_dokter', 'dokter_penyakit.kode_dokter')
                // ->groupBy('dokter_penyakit.kode_dokter')
                ->selectRaw("dokter.*,( 6370 * acos ( cos ( radians($latitude) ) * cos( radians( dokter.latitude ) ) * cos( radians( dokter.longitude ) - radians($longitude) ) + sin ( radians($latitude) ) * sin( radians( dokter.latitude ) ) ) ) AS distance")
                ->orderBy('distance', 'asc')
                ->having('distance', '<=', 20)
                ->get()
        );
        return response()->json([
            'message' => 'Berhasil',
            'data' => $data,
            'code' => 200
        ], 200);
    }
    public function dokterprofile(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $kode_dokter = $request->kode_dokter;
        $hariini = Helper::hari_ini();
        $data = MDokter::where('kode_dokter', $kode_dokter)
                ->with(['kategori','jam_operasional.datahari'])
                ->selectRaw("*,( 6370 * acos ( cos ( radians($latitude) ) * cos( radians( dokter.latitude ) ) * cos( radians( dokter.longitude ) - radians($longitude) ) + sin ( radians($latitude) ) * sin( radians( dokter.latitude ) ) ) ) AS distance")
                ->first()->toArray();
        $data['foto'] = url($data['foto']);
        $data['jam_operasional'] = collect($data['jam_operasional'])->sortBy([
            ['datahari.urutan', 'asc'],
        ])->values()->all();
        return response()->json([
            'message' => 'Berhasil',
            'data' => $data,
            'code' => 200
        ], 200);
    }
}
