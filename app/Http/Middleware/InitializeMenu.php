<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class InitializeMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        $link = $request->route()->getName();
        $id = session()->get('id');

        if ($this->getUserMenu($id, $link)) {
            return $next($request);
        } else {
            return redirect('/')->with([
                'deniedmiddlewaremenu' => [
                    'type' => 'warning',
                    'alert' => 'Anda tidak mempunyai akses untuk menuju halaman ini!',
                ],
            ]);
        }
    }

    public function getUserMenu($iduser, $link)
    {

        $query = DB::table("model_has_roles as mhr")
            ->join("role_has_menu as rhm", "rhm.role_id", "=", "mhr.role_id")
            ->join("masters.menu as m", "rhm.menu_id", "=", "m.id")
            ->where("link", $link)
            ->where("model_id", $iduser);

        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
