<?php

namespace App\Http\Controllers\Settings\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Logger\TraitsLoggerActivity;
use App\Traits\Yajra\Search\TraitsYajraSearch;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class SettingsUser extends Controller
{
    use TraitsYajraSearch, TraitsLoggerActivity;

    public function index()
    {
        $role = Role::all();
        return view('settings.user.index', compact('role'));
    }

    public function all()
    {
        $model = $this->queryModel();
        $tablesOfYajra = DataTables::of($model);
        $request = request()->all();

        $rules = [
            'mappingcolumn' => [],
            'renormalvalue' => [],
            'datecolumn' => [],
            'numbercolumn' => []
        ];

        return $this->searchYajra($tablesOfYajra, $request, $rules)->toJson();
    }

    public function queryModel()
    {
        $model = User::from("users as u")
            ->select(
                // "u.nama",
                DB::raw("u.password as pass"),
                "u.id",
                "u.telpon",
                "u.email",
                "u.name",
                DB::raw("convertnumericdatetoalphabetical(u.created_at::date) as created_at_view")
            )->with('roles');

        // dd(getSql($model));
        return $model;
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            $insert = [
                'password' => bcrypt($post['password'])
            ];

            $insert = array_merge($post, $insert);

            $user = User::create($insert);

            $user->assignRole($post['idrole']);

            $this->activity("Membuat pengguna [successfully]");

            DB::commit();

            $response = [
                'message' => 'Pengguna berhasil dibuat'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Membuat pengguna [failed]", $th->getMessage());

            $response = [
                'message' => 'Pengguna gagal dibuat'
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            if (User::count() == 1) throw new Exception("Pengguna tinggal 1 tidak boleh dihapus", 1);

            $user = User::find($post['id']);
            $user->syncRoles([]);
            $user->delete();

            $this->activity("Menghapus pengguna [successfully]");

            DB::commit();

            $response = [
                'message' => 'Pengguna berhasil dihapus'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Menghapus pengguna [failed]", $th->getMessage());

            if ($th->getCode() == 1) {
                $pesan = $th->getMessage();
            } else {
                $pesan = 'Pengguna gagal dihapus';
            }

            $response = [
                'message' => message($pesan, $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            $id = $post['id'];

            unset($post['id']);
            unset($post['password']);
            unset($post['repassword']);

            User::find($id)->update($post);
            $user = User::find($id);
            $user->syncRoles([$post['idrole']]);

            $this->activity("Mengubah pengguna [successfully]");

            DB::commit();

            $response = [
                'message' => 'Pengguna berhasil diubah'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Mengubah pengguna [failed]", $th->getMessage());

            if ($th->getCode() == 1) {
                $pesan = $th->getMessage();
            } else {
                $pesan = 'Pengguna gagal diubah';
            }

            $response = [
                'message' => message($pesan, $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }
}
