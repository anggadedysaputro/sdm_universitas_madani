<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Applications\Pegawai;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $jumlahpegawai = Pegawai::where("aktif", "Y")->count();
        return view('dashboard.index', compact('jumlahpegawai'));
    }
}
