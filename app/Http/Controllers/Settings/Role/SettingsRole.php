<?php

namespace App\Http\Controllers\Settings\Role;

use App\Http\Controllers\Controller;
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
        $permission = Permission::all();
        $role = Role::all();

        $roleData = [];
        foreach ($role as $key => $value) {

            $roleUsers = User::with('roles')->get()->filter(
                fn ($user) => $user->roles->where('name', $value->name)->toArray()
            );

            $data = [
                'jumlah' => count($roleUsers),
                'users' => $roleUsers->toArray(),
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
}
