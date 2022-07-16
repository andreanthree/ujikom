<?php

namespace App\Imports;

use App\Models\MMapel;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MapelImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $no = 0;
        foreach ($rows as $row) {
            // $validator = Validator::make($row, [
            //     0 => 'sometimes|required|string|max:100',
            //     1 => ['required', Rule::in('a', 'b', 'c1', 'c2', 'c3', 'mulok')],
            // ]);
            if ($no != 0 && $row[0] && in_array($row[1],['a', 'b', 'c1', 'c2', 'c3', 'mulok'])) {
                $cek = MMapel::where('nama_mapel', $row[0])->first();
                if (!$cek) {
                    MMapel::create([
                        'nama_mapel' => $row[0],
                        'tipe_mapel' => $row[1],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }

            $no++;
        }
        // return $no;
    }
}
