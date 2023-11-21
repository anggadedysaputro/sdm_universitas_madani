<?php

namespace App\Http\Controllers\Settings\Masters\SubUnit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsMastersSubunit extends Controller
{
    public function index()
    {
        return view('settings.masters.sub-unit.index');
    }
}
