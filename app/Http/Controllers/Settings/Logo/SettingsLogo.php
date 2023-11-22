<?php

namespace App\Http\Controllers\Settings\Logo;

use App\Http\Controllers\Controller;
use App\Models\Applications\Config;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingsLogo extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        $getLogo = Config::where('key', 'logo')->get();
        $logo = "";
        if (!$getLogo->isEmpty()) $logo = str_replace("public/", "", $getLogo[0]->value);

        return view('settings.logo.index', compact('logo'));
    }

    public function store()
    {
        DB::beginTransaction();
        $path = "";
        try {
            foreach (request()->file() as $key => $value) {
                $path = Storage::putFile('public/logo', $value);
                Config::updateOrCreate(
                    ['key' => 'logo'],
                    ['value' => $path]
                );
            }

            $this->activity("Upload logo [successfully]", "");

            $response = [
                'message' => 'Upload logo berhasil'
            ];

            DB::commit();

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            if (!empty($path)) Storage::delete($path);

            DB::rollback();

            $this->activity("Upload logo [failed]", $th->getMessage());


            $response = [
                'message' => message("Upload logo gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
