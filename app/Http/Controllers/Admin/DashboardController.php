<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        return view('pages.admin.dashboard', [
            'booking_list_all'          => 0,
            'booking_list_pending'      => 0,
            'booking_list_disetujui'    => 0,
            'booking_list_digunakan'    => 0,
            'booking_list_selesai'      => 0,
            'booking_list_ditolak'      => 0,
            'booking_list_batal'        => 0,
            'booking_list_expired'      => 0,
            'room'                      => 0,
            'user'                      => 0,
        ]);
    }
   
}
