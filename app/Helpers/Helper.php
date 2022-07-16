<?php

namespace App\Helpers;


class Helper
{
    public static function bobotToText($price)
    {
        try {
            if ((int)$price <= 20) {
                return "Sangat Rendah";
            }else if ((int)$price <= 40) {
                return "Rendah";
            }else if ((int)$price <= 60) {
                return "Menengah";
            }else if ((int)$price <= 80) {
                return "Tinggi";
            }else if ((int)$price <= 1000) {
                return "Sangat Tinggi";
            }else{
                return $price;
            }
        } catch (\Throwable $th) {
            return $price;
        }
    }
    public static function convertGender($price)
    {
        try {
            $dat = [
                'L' => "Laki-Laki",
                'P' => "Perempuan"
            ];
            return $dat[$price];
        } catch (\Throwable $th) {
            return $price;
        }
    }
    public static function calcCoordinates($latitude,$longitude,  $radius = 20)
    {
        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

        return [
            'min' => [
                'lat' => $lat_min,
                'lng' => $lng_min,
            ],
            'max' => [
                'lat' => $lat_max,
                'lng' => $lng_max,
            ],
        ];
    }
    public static function hari_ini()
  {
    $hari = date("D");

    switch ($hari) {
      case 'Sun':
        $hari_ini = "Minggu";
        break;

      case 'Mon':
        $hari_ini = "Senin";
        break;

      case 'Tue':
        $hari_ini = "Selasa";
        break;

      case 'Wed':
        $hari_ini = "Rabu";
        break;

      case 'Thu':
        $hari_ini = "Kamis";
        break;

      case 'Fri':
        $hari_ini = "Jumat";
        break;

      case 'Sat':
        $hari_ini = "Sabtu";
        break;

      default:
        $hari_ini = "Tidak di ketahui";
        break;
    }

    return $hari_ini;
  }
    public static function price($price)
    {
        try {
            return "Rp " . number_format($price, 0, ',', '.');
        } catch (\Throwable $th) {
            return $price;
        }
    }
    public static function uang($price)
    {
        try {
            return number_format($price, 0, ',', '.');
        } catch (\Throwable $th) {
            return $price;
        }
    }
    public static function nullHelper($params, $key)
    {
        if ($params) {
            return json_decode($params, true)[$key];
        } else {
            return "";
        }
    }
    public static function tanggal($tgl)
    {
        try {
            $qq = '';
            $k = explode("-", $tgl);
            $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            $qq = $k[2] . ' ' . $bln[(int)$k[1]] . ' ' . $k[0];
            return $qq;
        } catch (\Throwable $th) {
            return $tgl;
        }
    }
    public static function ambiltahun($tgl)
    {
        try {
            $qq = '';
            $k = explode("-", $tgl);
            return $k[0];
        } catch (\Throwable $th) {
            return $tgl;
        }
    }
    public static function bulantahun($tgl)
    {
        try {
            $qq = '';
            $k = explode("-", $tgl);
            $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            $qq = $bln[(int)$k[1]] . ' ' . $k[0];
            return $qq;
        } catch (\Throwable $th) {
            return $tgl;
        }
    }
    public static function waktu($tgl)
    {
        try {
            $qq = '';
            $k = explode(" ", $tgl);
            $kk = explode("-", $k[0]);
            $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

            $qq = $kk[2] . ' ' . $bln[(int)$kk[1]] . ' ' . $kk[0] . ' ' . $k[1];
            return $qq;
        } catch (\Throwable $th) {
            return $tgl;
        }
    }

    public static function gettanggaldatetime($tgl)
    {
        try {
            $qq = '';
            $k = explode(" ", $tgl);
            $kk = explode("-", $k[0]);
            $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

            $qq = $kk[2] . ' ' . $bln[(int)$kk[1]] . ' ' . $kk[0];
            return $qq;
        } catch (\Throwable $th) {
            return $tgl;
        }
    }


    public static function random_number($maxlength)
    {
        $chary = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $return_str = "";
        for ($x = 0; $x < $maxlength; $x++) {
            $return_str .= $chary[rand(0, count($chary) - 1)];
        }
        return $return_str;
    }

    public static function getNumber($kalimat)
    {
        try {

            $int = filter_var($kalimat, FILTER_SANITIZE_NUMBER_INT);
            return $int;
        } catch (\Throwable $th) {
            return $kalimat;
        }
    }
    public static function bersihkanangka($kalimat)
    {
        try {
            $re = array();
            $re[0] = ".";
            $re[1] = ",";
            $re[2] = "-";
            $dat = array();
            $dat[0] = "";
            $dat[1] = "";
            $dat[2] = "";
            return str_replace($re, $dat, $kalimat);
        } catch (\Throwable $th) {
            return $kalimat;
        }
    }

    public static function penyebut($nilai)
    {
        try {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " " . $huruf[$nilai];
            } else if ($nilai < 20) {
                $temp = Helper::penyebut($nilai - 10) . " belas";
            } else if ($nilai < 100) {
                $temp = Helper::penyebut($nilai / 10) . " puluh" . Helper::penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . Helper::penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = Helper::penyebut($nilai / 100) . " ratus" . Helper::penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . Helper::penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = Helper::penyebut($nilai / 1000) . " ribu" . Helper::penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = Helper::penyebut($nilai / 1000000) . " juta " . Helper::penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = Helper::penyebut($nilai / 1000000000) . " milyar" . Helper::penyebut(fmod($nilai, 1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = Helper::penyebut($nilai / 1000000000000) . " trilyun" . Helper::penyebut(fmod($nilai, 1000000000000));
            }
            return trim($temp);
        } catch (\Throwable $th) {
            return $nilai;
        }
    }
}
