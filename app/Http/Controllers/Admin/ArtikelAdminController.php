<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MArtikel;
use App\Models\MWriter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ArtikelAdminController extends Controller
{

    private $dataPage = [
        'redirectIndex' => "admin/artikel",
        'primaryKey' => "id_artikel",
        'baseview' => "pages.admin.artikel.",
        'title' => "Data Artikel",
        'indexnama' => "judul_artikel",
        'keyuniq' => "judul_artikel",
        'formData' => []
    ];
    public function index()
    {
        return view($this->dataPage['baseview'] . 'index', [
            'dataPage' => $this->dataPage
        ]);
    }
    public function json()
    {
        $data = MArtikel::with(['penulis'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function destroy(Request $request, $id)
    {
        $item = MWriter::where([$this->dataPage['primaryKey'] => $id]);
        $itemFirst = $item->first()->toArray();
        if ($item->delete()) {
            $request->session()->flash('alert-success', $this->dataPage['title'] . ' ' . $itemFirst[$this->dataPage['indexnama']] . ' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'] . ' ' . $itemFirst[$this->dataPage['indexnama']] . ' gagal diupdate');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
}
