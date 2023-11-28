<?php

namespace App\Http\Controllers\Settings\Role;

use App\Http\Controllers\Controller;
use App\Models\Public\RoleHasMenu;
use App\Models\User;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SettingsRole extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        $permission = Permission::orderBy("name")->get();
        $role = Role::all();

        $roleData = [];
        foreach ($role as $key => $value) {

            $roleUsers = User::with('roles')->get()->filter(
                fn ($user) => $user->roles->where('name', $value->name)->toArray()
            );

            $menu = RoleHasMenu::where('role_id', $value->id)->count();

            $data = [
                'jumlah' => count($roleUsers),
                'users' => $roleUsers->toArray(),
                'jumlahmenu' => $menu,
                'idrole' => $value->id
            ];

            $roleData[$value->name] = $data;
        }

        return view('settings.role.index', [
            'permission' => $permission,
            'role' => $roleData
        ]);
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            $roleName = request('rolename');

            $permissionAllowed = [];

            foreach (request('create') as $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) array_push($permissionAllowed, request('permissionname')[$key]);
            }

            $role = Role::create(['name' => $roleName]);

            $role->syncPermissions($permissionAllowed);

            if (request()->has('menu')) {
                $map = array_map(function ($item) use ($role) {
                    $array['role_id'] = $role->id;
                    $array['menu_id'] = $item;
                    return $array;
                }, request('menu'));
                RoleHasMenu::upsert($map, ['menu_id', 'role_id']);
            }

            $this->activity("Input role [successfully]");

            DB::commit();

            $response = [
                'message' => 'Input role success'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("Input role [failed]", $th->getMessage());

            $response = [
                'message' => 'Input role failed'
            ];

            return response()->json($response, 500);
        }
    }

    public function mypermission()
    {
        try {
            $roleName = request('name');

            $role = Role::where('name', $roleName)->with('permissions');

            $response = [
                'message' => 'Mendapatkan izin peran berhasil',
                'data' => $role->get()
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("Mendapatkan izin peran [failed]", $th->getMessage());

            $response = [
                'message' => 'Mendapatkan izin gagal'
            ];

            return response()->json($response, 500);
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $roleName = request('rolename');
            $id = request('id');

            $permissionAllowed = [];

            foreach (request('create') as $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) array_push($permissionAllowed, request('permissionname')[$key]);
            }

            Role::find($id)->update([
                'name' => $roleName
            ]);

            Role::find($id)->syncPermissions($permissionAllowed);
            RoleHasMenu::where('role_id', $id)->delete();

            if (request()->has('menu')) {
                $map = array_map(function ($item) use ($id) {
                    $array['role_id'] = $id;
                    $array['menu_id'] = $item;
                    return $array;
                }, request('menu'));

                RoleHasMenu::upsert($map, ['menu_id', 'role_id']);
            }

            $this->activity("Mengubah peran [successfully]");

            DB::commit();

            $response = [
                'message' => 'Mengubah peran berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());

            $this->activity("Mengubah peran [failed]", $th->getMessage());

            $response = [
                'message' => 'Mengubah peran gagal'
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $id = request('id');

            Role::find($id)->delete();

            $this->activity("Menghapus peran [successfully]");

            DB::commit();

            $response = [
                'message' => 'Menghapus peran berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("Menghapus peran [failed]", $th->getMessage());

            $response = [
                'message' => 'Menghapus peran gagal'
            ];

            return response()->json($response, 500);
        }
    }
}
