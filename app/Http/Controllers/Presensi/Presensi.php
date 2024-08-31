<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Presensi extends Controller
{
    public function index()
    {
        return view('presensi.index');
    }
}
