<?php

namespace App\Http\Controllers;

use App\Models\Public\RoleHasMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
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
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // dd(Auth::attempt($credentials));
            if (Auth::attempt($credentials)) {
                $user = Auth::user()->with('roles')->get()->toArray()[0];
                $roleId = $user['roles'][0]['id'];

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
                    ->where('role_id', $roleId)->get()->toArray();

                $user['menu'] = getChildRecursive($menuRole);
                session($user);
                $request->session()->regenerate();

                return redirect()->intended('index');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
