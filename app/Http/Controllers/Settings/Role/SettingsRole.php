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
            $permissionAllowed = request('create');

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
            dd($th->getMessage());
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

            $role = Role::all();

            $data = [];

            foreach ($role->toArray() as $rolename) {
                $data[$rolename['name']] = [];

                foreach (Permission::all()->toArray() as $permission) {
                    $role = new Role();
                    $tmp = [
                        'name' => $permission['name'],
                        'checked' => $role->hasPermissionTo($permission['name']),
                        'id' => $permission['id']
                    ];

                    $data[$rolename['name']][$permission['id']] = $tmp;
                }
            }

            $response = [
                'message' => 'Mendapatkan izin peran berhasil',
                'data' => $data
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->activity("Mendapatkan izin peran [failed]", $th->getMessage());

            $response = [
                'message' => message('Mendapatkan izin gagal', $th->getMessage())
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

            $permissionAllowed = request('create') ?? [];

            $permission = DB::table('role_has_permissions')->where('role_id', $id)->get()->pluck('permission_id')->toArray();
            // $permissionAllowed = array_merge($permission, $permissionAllowed);
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

    public function fullAkses()
    {
        try {
            $query = DB::table('permissions as rhp')
                ->select(
                    "rhp.id",
                    "rhp.name",
                    DB::raw("true as checked")
                )->get()->toArray();

            $array = [];
            foreach ($query as $key => $value) {
                $array[$value->id] = (array)$value;
            }

            $response = [
                'data' => $array
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {

            $response = [
                'message' => message('Mendapatkan data akses pada peran gagal', $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
