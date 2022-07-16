<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MWriter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WriterAdminController extends Controller
{

    private $dataPage = [
        'redirectIndex' => "admin/penulis",
        'primaryKey' => "id_penulis",
        'baseview' => "pages.admin.penulis.",
        'title' => "Data Penulis",
        'indexnama' => "nama",
        'keyuniq' => "nama",
        'formData' => [
            [
                "name" => "nama",
                "label" => "Nama penulis",
                "placeholder" => "Masukkan Nama penulis",
                "type" => "text",
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required|string|max:75",
                "value" => ""
            ],
            [
                "name" => "biografi",
                "label" => "Biografi",
                "placeholder" => "Masukkan Biografi",
                "type" => "textarea",
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "string",
                "value" => ""
            ],

            [
                "name" => "status_penulis",
                "label" => "Status penulis",
                "placeholder" => "Masukkan Status penulis",
                "type" => "select",
                "selectedId" => "select",
                "data" => [
                    [
                        'id' => 'Active',
                        'label' => 'Active',
                    ],
                    [
                        'id' => 'Non-Active',
                        'label' => 'Non-Active',
                    ],
                ],
                "form_group_class" => "required",
                "other_attributes" => "required",
                "rule" => "required",
                "value" => ""
            ],
        ]
    ];
    public function index()
    {
        return view($this->dataPage['baseview'] . 'index', [
            'dataPage' => $this->dataPage
        ]);
    }
    public function json()
    {
        $data = MWriter::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    public function create()
    {
        $dataPage = $this->dataPage;
        return view($this->dataPage['baseview'] . 'edit_or_create', [
            'dataPage' => $dataPage,
        ]);
    }
    public function edit($id)
    {
        $item = MWriter::where([$this->dataPage['primaryKey'] => $id])->first();
        $dataPage = $this->dataPage;

        $dataPage['formData'][2]['selectedId'] = $item->status_penulis;
        return view($this->dataPage['baseview'] . 'edit_or_create', [
            'item' => $item,
            'dataPage' => $dataPage,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = MWriter::where([$this->dataPage['primaryKey'] => $id]);
        $itemFirst = $item->first()->toArray();

        $arrRule = [];
        foreach ($this->dataPage['formData'] as $vl) {
            $rule = $vl['rule'];
            if ($vl['name'] === $this->dataPage['keyuniq']) {
                $rule .= ',' . $id . ',' . $this->dataPage['primaryKey'];
            }
            $arrRule[$vl['name']] = $rule;
        }
        $request->validate($arrRule);
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);

        if ($item->update($data)) {
            $request->session()->flash('alert-success', $this->dataPage['title'] . ' ' . $itemFirst[$this->dataPage['indexnama']] . ' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'] . ' ' . $itemFirst[$this->dataPage['indexnama']] . ' gagal diupdate');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
    public function destroy(Request $request, $id)
    {
        $item = MWriter::where([$this->dataPage['primaryKey'] => $id]);
        $itemFirst = $item->first()->toArray();
        if ($item->delete()) {
            $request->session()->flash('alert-success', $this->dataPage['title'] . ' ' . $itemFirst[$this->dataPage['indexnama']] . ' berhasil dihapus');
        } else {
            $request->session()->flash('alert-failed', $this->dataPage['title'] . ' ' . $itemFirst[$this->dataPage['indexnama']] . ' gagal dihapus');
        }

        return redirect(url($this->dataPage['redirectIndex']));
    }
}
