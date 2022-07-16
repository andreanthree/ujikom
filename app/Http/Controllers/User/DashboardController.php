<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MArtikel;
use App\Models\MArtikelKomentar;
use App\Models\MKomentar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard_booking_list(){
       
    }

    public function index()
    {
        $data = MArtikel::with(['penulis'])->get();
        return view('pages.landing', compact('data'));
        
    }
    public function detailartikel($id)
    {
        $data = MArtikel::where('id', $id)->with(['penulis','listkomentar.komentar'])->first();
        // return $data;
        return view('pages.detailartikel', compact('data'));
    }
    public function kirimkomen(Request $request, $id)
    {
        $komen = MKomentar::create([
            'nama'=>$request->nama,
            'isi_komentar'=>$request->isi_komentar,
            'email'=>$request->email,
            'waktu'=> Carbon::now(),
        ]);
        MArtikelKomentar::create([
            'id_artikel' => $id,
            'id_komentar' => $komen->id,
        ]);
        $request->session()->flash('alert-success', 'komentar berhasil dikirim');

        return redirect(url('detailartikel/'.$id));
    }
}
