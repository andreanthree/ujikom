<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MArtikel;
use App\Models\MArtikelKomentar;
use App\Models\MKomentar;
use App\Models\MWriter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KomentarAdminController extends Controller
{

    private $dataPage = [
        'redirectIndex' => "admin/komentar",
        'primaryKey' => "",
        'baseview' => "pages.admin.komentar.",
        'title' => "Komentar",
        'indexnama' => "judul_artikel",
        'keyuniq' => "judul_artikel",
        'formData' => []
    ];
    public function index()
    {
        // $data = MArtikelKomentar::with(['artikel','komentar'])->get();
        // return $data;
        return view($this->dataPage['baseview'] . 'index', [
            'dataPage' => $this->dataPage
        ]);
    }
    public function json()
    {
        $data = MArtikelKomentar::with(['artikel','komentar'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function destroy(Request $request, $id)
    {
        $item = MArtikelKomentar::where(['id' => $id]);
        $itemFirst = $item->first()->toArray();
        MKomentar::where(['id' => $itemFirst['id_komentar']]);
        if ($item->delete()) {
            $request->session()->flash('alert-success', 'komentar berhasil dihapus');
        } else {
            $request->session()->flash('alert-failed', 'komentar gagal dihapus');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
}
