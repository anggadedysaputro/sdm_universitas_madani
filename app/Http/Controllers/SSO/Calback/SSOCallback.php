<?php

namespace App\Http\Controllers\SSO\Calback;

use App\Http\Controllers\Controller;
use App\Models\Applications\ConfigApp;
use App\Models\Public\RoleHasMenu;
use App\Models\User;
use App\Services\Settings\Users\ServicesSettingsUsers;
use App\Traits\Logger\TraitsLoggerActivity;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SSOCallback extends Controller
{

    use TraitsLoggerActivity;

    public function callbackUrl(Request $request)
    {
        $accessToken = $request->cookie(env('COOKIE_ACCESS_NAME'));

        if (!$accessToken) return redirect()->route('login');

        try {
            // Verifikasi JWT menggunakan secret atau public key server SSO
            $decoded = JWT::decode($accessToken, new Key(env('JWT_ACCESS_SECRET'), 'HS256'));

            // dd(gmdate("Y-m-d H:i:s", $decoded->exp), gmdate("Y-m-d H:i:s", time()));

            $user = User::where("email", $decoded->email);

            if ($user->isNotEmpty()) {
                Auth::login($user->first());


                if (Auth::check()) {
                    $user = Auth::user()->toArray();
                    $roleId = Auth::user()->roles->pluck('id')->first();
                    $menuRole = RoleHasMenu::select(
                        "masters.menu.id",
                        "masters.menu.nama",
                        "masters.menu.link",
                        "masters.menu.parent as parents",
                        "masters.icon.nama as nama_icon",
                    )
                        ->join("masters.menu", "role_has_menu.menu_id", "=", "masters.menu.id")
                        ->join("masters.icon", "masters.menu.icon_id", "=", "masters.icon.id")
                        ->where('masters.menu.isactive', true)
                        ->where('masters.menu.location', "normal")
                        ->where('role_id', $roleId)->get()->toArray();

                    $user['menu'] = getChildRecursive($menuRole);
                    $user['tahun'] = date("Y");
                    $user['tahunaktif'] = date("Y");
                    $user['rolename'] = Auth::user()->getRoleNames()[0];
                    $user['konfigumum'] = ConfigApp::from("applications.configapp as ca")
                        ->select("ku.*", "ca.tahun")
                        ->join("applications.konfigumum as ku", "ku.idkonfigumum", "=", "ca.idkonfig")
                        ->where("ca.aktif", true)->get()->toArray();
                    if (!empty($user['konfigumum'])) $user['konfigumum'] = $user['konfigumum'][0];
                    session($user);
                    $request->session()->regenerate();

                    $this->activity("Login SSO [successfully]", "");

                    return redirect()->intended('index');
                } else {
                    return redirect()->route('login');
                }
            }

            // Redirect ke halaman utama
            return redirect()->route('login');
        } catch (\Exception $e) {
            // Tangani error verifikasi
            $this->activity("Login SSO [failed]", $e->getMessage());
            return redirect()->route('login');
        }
    }
}
