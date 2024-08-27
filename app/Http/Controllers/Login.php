<?php

namespace App\Http\Controllers;

use App\Models\Applications\ConfigApp;
use App\Models\Public\RoleHasMenu;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('login');
    }
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required'],
                'password' => ['required'],
            ]);
            // dd('sdf');
            // dd(Auth::attempt($credentials));
            if (Auth::attempt($credentials)) {
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

                $this->activity("Login [successfully]", "");

                return redirect()->intended('index');
            }
            $this->activity("Login [failed]");
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->activity("Login [failed]", $th->getMessage());
            return back()->withErrors([
                'message' => 'Login gagal'
            ]);
        }
    }
}
