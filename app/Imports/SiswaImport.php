<?php

namespace App\Imports;

use App\Models\MSiswa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SiswaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $no = 0;
        $buku = Session::get('buku');
        $kodebuku = $buku->kode_buku;
        foreach ($rows as $row) {
            if ($no != 0) {
                $cek = MSiswa::where(['nipd'=> $row[2],'nisn'=> $row[4]])->first();
                if (!$cek) {
                    $kodesiswa = Str::random(32);
                    MSiswa::create([
                        'kode_siswa' => $kodesiswa,
                        'kode_buku' => $kodebuku,
                        'nama_siswa' => $row[1],
                        'nama_panggilan' => $row[2],
                        'nisn' => $row[3],
                        'nipd' => $row[4],
                        'gender' => $row[5],
                        'kewarganegaraan' => $row[6],
                        'saudara_kandung' => $row[7],
                        'saudara_tiri' => $row[8],
                        'saudara_angkat' => $row[9],
                        'status_yatim' => $row[10],
                        'bahasa' => $row[11],
                        'alamat' => $row[12],
                        'no_hp' => $row[13],
                        'status_tinggal' => $row[14],
                        'jarak_sekolah' => $row[15],
                        'gol_darah' => $row[16],
                        'penyakit' => $row[17],
                        'kelainan' => $row[18],
                        'tinggi' => $row[19],
                        'berat' => $row[20],
                        'tamatan_dari' => $row[21],
                        'tamatan_no_ijazah' => $row[22],
                        'tamatan_no_skhun' => $row[23],
                        'tamatan_lama' => $row[24],
                        'pindahan_dari' => $row[25],
                        'pindahan_alasan' => $row[26],
                        'diterima_kelas' => $row[27],
                        'ayah_nama' => $row[28],
                        'ayah_tmp_lahir' => $row[29],
                        'ayah_tgl_lahir' => $row[30],
                        'ayah_agama' => $row[31],
                        'ayah_kewarganegaraan' => $row[32],
                        'ayah_pendidikan' => $row[33],
                        'ayah_pekerjaan' => $row[34],
                        'ayah_pengeluaran' => $row[35],
                        'ayah_alamat_nohp' => $row[36],
                        'ayah_status' => $row[37],
                        'ibu_nama' => $row[38],
                        'ibu_tmp_lahir' => $row[39],
                        'ibu_tgl_lahir' => $row[40],
                        'ibu_agama' => $row[41],
                        'ibu_kewarganegaraan' => $row[42],
                        'ibu_pendidikan' => $row[43],
                        'ibu_pekerjaan' => $row[44],
                        'ibu_pengeluaran' => $row[45],
                        'ibu_alamat_nohp' => $row[46],
                        'ibu_status' => $row[47],
                        'wali_nama' => $row[48],
                        'wali_tmp_lahir' => $row[49],
                        'wali_tgl_lahir' => $row[50],
                        'wali_agama' => $row[51],
                        'wali_kewarganegaraan' => $row[52],
                        'wali_pendidikan' => $row[53],
                        'wali_pekerjaan' => $row[54],
                        'wali_pengeluaran' => $row[55],
                        'wali_alamat_nohp' => $row[56],
                        'kesenian' => $row[57],
                        'olahraga' => $row[58],
                        'organisasi' => $row[59],
                        'hobi_lain_lain' => $row[60],
                        'beasiswa_satu' => json_encode([
                            'tahun' => $row[61],
                            'kelas' => $row[62],
                            'dari' => $row[63],
                        ]),
                        'beasiswa_dua' => json_encode([
                            'tahun' => $row[64],
                            'kelas' => $row[65],
                            'dari' => $row[66],
                        ]),
                        'beasiswa_tiga' => json_encode([
                            'tahun' => $row[67],
                            'kelas' => $row[68],
                            'dari' => $row[69],
                        ]),
                        'keluar_tanggal' => $row[70],
                        'keluar_alasan' => $row[71],
                        'lulus_tanggal' => $row[72],
                        'lulus_no_ijazah' => $row[73],
                        'lulus_no_skhun' => $row[74],
                        'lulus_melanjutkan' => $row[75],
                        'bekerja_di' => $row[76],
                        'bekerja_tanggal' => $row[77],
                        'bekerja_perusahaan' => $row[78],
                        'bekerja_penghasilan' => $row[79],
                        'anak_ke' => $row[80],
                        'diterima_pada' => $row[81],
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
