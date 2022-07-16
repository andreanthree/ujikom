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
use App\Models\MPenyakit;
use Illuminate\Http\Request;

class DataApiController extends Controller
{

    public function dashboard()
    {
        $penyakit = MPenyakit::count();
        $gejala = MGejala::count();
        $aturan = MAturan::count();
        $dokter = MDokter::whereIn('status_dokter',['Aktif','Libur'])->count();

        return response()->json([
            'message' => 'Berhasil',
            'penyakit' => $penyakit,
            'gejala' => $gejala,
            'dokter' => $dokter,
            'aturan' => $aturan,
            'statistik' => $aturan,
            'code' => 200
        ], 200);
    }
    public function gejala()
    {
        $data = GejalaGrupResource::collection(MGejalaGrup::orderBy('urutan', 'asc')->get());

        return response()->json([
            'message' => 'Berhasil',
            'data' => $data,
            'code' => 200
        ], 200);
    }
    public function master()
    {
        $gejala = GejalaGrupResource::collection(MGejalaGrup::orderBy('urutan', 'asc')->get());
        $aturan = MAturan::with(['penyakit', 'user', 'aturanitem.gejala'])->get();

        return response()->json([
            'message' => 'Berhasil',
            'gejala' => $gejala,
            'aturan' => $aturan,
            'code' => 200
        ], 200);
    }

    public function analisis(Request $request)
    {
        $selected = explode(",", $request->data_selected);
        // return $selected;
        $master = MAturan::with(['penyakit', 'user', 'aturanitem.gejala'])
        ->where('status_aturan','Active')
        ->get();
        $send = [];
        foreach ($master as $val) {
            $bobotAkhir = 0;
            $bobotTotal = 0;
            $logGejala = [];
            foreach ($val->aturanitem as $ke) {
                $bobotTotal += $ke->bobot;
                $gejalaada = false;
                $cek = false;
                foreach ($selected as $sl) {
                    if ($ke->kode_gejala === $sl) {
                        $cek = true;
                    }
                }

                if ($cek) {
                    $bobotAkhir += $ke->bobot;
                    $gejalaada = true;
                }
                $logGejala[] = [
                    'kode_gejala' => $ke->kode_gejala,
                    'nama_gejala' => $ke->gejala->nama_gejala,
                    'bobot' => $ke->bobot,
                    'ada' => $gejalaada,
                ];
            }
            $nilai = ($bobotAkhir === 0 ? 0 : $bobotAkhir / $bobotTotal * 100);
            if ($nilai > 0) {
                $send[] = [
                    'kode_aturan' => $val->kode_aturan,
                    'kode_penyakit' => $val->kode_penyakit,
                    'nama_penyakit' => $val->penyakit->nama_penyakit,
                    'pembuat' => $val->user->name,
                    'pembuat_role' => $val->user->role,
                    'pembuat_id' => $val->user->id,
                    'pembuat_kode_dokter' => $val->user->akses_data,
                    'solusi' => $val->solusi,
                    'result' => [
                        'bobot_total' => $bobotTotal,
                        'bobot_akhir' => $bobotAkhir,
                        'nilai' => $nilai,
                        'log_gejala' => $logGejala,
                    ],
                ];
            }
        }
        return response()->json([
            'message' => 'Berhasil',
            'data' => $send,
            'code' => 200
        ], 200);
    }
}
