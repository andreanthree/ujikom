<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\MWriter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ArtikelWriterController extends Controller
{

    private $dataPage = [
        'redirectIndex' => "dokter/jadwal",
        'primaryKey' => "kode_jadwal",
        'baseview' => "pages.dokter.jadwal.",
        'title' => "Jadwal",
        'routejson' => "jadwaljson",
        'indexnama' => "hari",
        'keyuniq' => "",
        'formData' => [
            [
                "name" => "hari",
                "label" => "Hari",
                "placeholder" => "",
                "type" => "select",
                "selectedId" => "select",
                "data" => [
                    ['id' => 'Senin','label' => 'Senin'],
                    ['id' => 'Selasa','label' => 'Selasa'],
                    ['id' => 'Rabu','label' => 'Rabu'],
                    ['id' => 'Kamis','label' => 'Kamis'],
                    ['id' => 'Jumat','label' => 'Jumat'],
                    ['id' => 'Sabtu','label' => 'Sabtu'],
                    ['id' => 'Minggu','label' => 'Minggu'],
                ],
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required|string",
                "value" => ""
            ],
            [
                "name" => "status_jadwal",
                "label" => "Status Jadwal",
                "placeholder" => "",
                "type" => "select",
                "selectedId" => "select",
                "data" => [
                    ['id' => 'Aktif','label' => 'Aktif'],
                    ['id' => 'Non-Aktif','label' => 'Non-Aktif'],
                ],
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required|string",
                "value" => ""
            ],
            [
                "name" => "mulai",
                "label" => "Waktu Mulai",
                "placeholder" => "Pilih Waktu Mulai",
                "type" => "time",
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required",
                "value" => ""
            ],

            [
                "name" => "selesai",
                "label" => "Waktu Selesai",
                "placeholder" => "Pilih Waktu Selesai",
                "type" => "time",
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required|after_or_equal:mulai",
                "value" => ""
            ]
        ]
    ];
    public function index()
    {
        return view($this->dataPage['baseview'].'index',[
            'dataPage' => $this->dataPage
        ]);
    }
    public function json()
    {
        $data = MWriter::where('kode_dokter', Auth::user()->akses_data)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
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
        unset($data['_method']);
        unset($data['_token']);
        $data[$this->dataPage['primaryKey']] = Str::random(16);
        $data['created_at'] = Carbon::now();
        $data['created_by'] = Auth::user()->id;
        $data['kode_dokter'] = Auth::user()->akses_data;
        $create_room = MWriter::create($data);
        
        if($create_room) {
            $request->session()->flash('alert-success', $this->dataPage['title'].' '.$data[$this->dataPage['indexnama']].' berhasil ditambahkan');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'].' '.$data[$this->dataPage['indexnama']].' gagal ditambahkan');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = MWriter::where([$this->dataPage['primaryKey']=>$id])->first();
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
        $item = MWriter::where([$this->dataPage['primaryKey']=>$id]);
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
        $item = MWriter::where([$this->dataPage['primaryKey']=>$id]);
        $itemFirst = $item->first()->toArray();
        if($item->delete()) {
            $request->session()->flash('alert-success', $this->dataPage['title'].' '.$itemFirst[$this->dataPage['indexnama']].' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'].' '.$itemFirst[$this->dataPage['indexnama']].' gagal diupdate');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }

}
