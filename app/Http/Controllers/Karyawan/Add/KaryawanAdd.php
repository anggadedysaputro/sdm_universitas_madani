<?php

namespace App\Http\Controllers\Karyawan\Add;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KaryawanAdd extends Controller
{
    public function index()
    {
        return view('karyawan.add.index');
    }
}
