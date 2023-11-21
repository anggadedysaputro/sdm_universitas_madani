<?php

namespace App\Http\Controllers\Settings\Logo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsLogo extends Controller
{
    public function index()
    {
        return view('settings.logo.index');
    }
}
