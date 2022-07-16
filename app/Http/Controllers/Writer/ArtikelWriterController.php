<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\MArtikel;
use App\Models\MArtikelKomentar;
use App\Models\MKomentar;
use App\Models\MWriter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ArtikelWriterController extends Controller
{

    private $dataPage = [
        'redirectIndex' => "penulis/artikelpenulis",
        'primaryKey' => "id",
        'baseview' => "pages.penulis.artikel.",
        'title' => "Artikel Saya",
        'routejson' => "penulisartikeljson",
        'indexnama' => "judul_artikel",
        'keyuniq' => "",
        'formData' => [
            [
                "name" => "judul_artikel",
                "label" => "Judul Artikel",
                "placeholder" => "Masukkan Judul Artikel",
                "type" => "text",
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required|string|max:50",
                "value" => ""
            ],
            [
                "name" => "isi_artikel",
                "label" => "Deskripsi",
                "placeholder" => "Masukkan Deskripsi",
                "type" => "textarea",
                "form_group_class" => "required col-md-12",
                "other_attributes" => "required ",
                "rule" => "string",
                "value" => ""
            ],

        ]
    ];
    public function index()
    {
        // $getId = MWriter::where('id_user', Auth::user()->id)->first();
        // $data = MArtikel::where('id_penulis', $getId->id)->with(['penulis'])->get();
        // return $data;
        return view($this->dataPage['baseview'].'index',[
            'dataPage' => $this->dataPage
        ]);
    }
    public function json()
    {
        $getId = MWriter::where('id_user', Auth::user()->id)->first();
        $data = MArtikel::where('id_penulis', $getId->id_penulis)->with(['penulis'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function getartikelkomen($id)
    {
        $data = MArtikelKomentar::where('id_artikel',$id)->with(['artikel','komentar'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    
    public function deletekomentar(Request $request, $id, $idartikel)
    {
        $item = MArtikelKomentar::where(['id' => $id]);
        $itemFirst = $item->first()->toArray();
        MKomentar::where(['id' => $itemFirst['id_komentar']]);
        if ($item->delete()) {
            $request->session()->flash('alert-success', 'komentar berhasil dihapus');
        } else {
            $request->session()->flash('alert-failed', 'komentar gagal dihapus');
        }

        return redirect(url($this->dataPage['redirectIndex'].'/'.$idartikel));
    }
    public function create()
    {
        return view($this->dataPage['baseview'].'edit_or_create',[
            'dataPage' => $this->dataPage,
        ]);
    }
    public function store(Request $request)
    {
        $arrRule = [];
        foreach ($this->dataPage['formData'] as $vl) {
            $arrRule[$vl['name']] = $vl['rule'];
        }
        $request->validate($arrRule);
        $data = $request->all();

        $getId = MWriter::where('id_user', Auth::user()->id)->first();
        unset($data['_method']);
        unset($data['_token']);
        $data['tanggal'] = date('Y-m-d');
        $data['id_penulis'] = $getId->id_penulis;
        // return $data;
        $create_room = MArtikel::create($data);
        
        if($create_room) {
            $request->session()->flash('alert-success', $this->dataPage['title'].' '.$data[$this->dataPage['indexnama']].' berhasil ditambahkan');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'].' '.$data[$this->dataPage['indexnama']].' gagal ditambahkan');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
    public function show($id)
    {

        $data = MArtikel::where('id', $id)->first();
        // return $data;
        
        return view($this->dataPage['baseview'] . 'detail', [
            'data' => $data,
            'dataPage' => $this->dataPage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = MArtikel::where([$this->dataPage['primaryKey']=>$id])->first();
        $dataPage = $this->dataPage;
        $dataPage['formData'][0]['selectedId'] = $item->hari;
        $dataPage['formData'][1]['selectedId'] = $item->status_jadwal;
        return view($this->dataPage['baseview'].'edit_or_create',[
            'item' => $item,
            'dataPage' => $dataPage,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = MArtikel::where([$this->dataPage['primaryKey']=>$id]);
        $itemFirst = $item->first()->toArray();

        $arrRule = [];
        foreach ($this->dataPage['formData'] as $vl) {
            $rule = $vl['rule'];
            if ($vl['name'] === $this->dataPage['keyuniq']) {
                $rule .= ','.$id.','.$this->dataPage['primaryKey'];
            }
            $arrRule[$vl['name']] = $rule;
        }
        $request->validate($arrRule);
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);

        if($item->update($data)) {
            $request->session()->flash('alert-success', $this->dataPage['title'].' '.$itemFirst[$this->dataPage['indexnama']].' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'].' '.$itemFirst[$this->dataPage['indexnama']].' gagal diupdate');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
    public function destroy(Request $request, $id)
    {
        $item = MArtikel::where([$this->dataPage['primaryKey']=>$id]);
        $itemFirst = $item->first()->toArray();
        if($item->delete()) {
            MArtikelKomentar::where('id_artikel',$id)->delete();
            $request->session()->flash('alert-success', $this->dataPage['title'].' '.$itemFirst[$this->dataPage['indexnama']].' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'].' '.$itemFirst[$this->dataPage['indexnama']].' gagal diupdate');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
    

}
