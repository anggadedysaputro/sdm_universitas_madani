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

    public function data()
    {

        $query = DB::table(
            DB::raw("
                (
                    select users.id,
                        users.name,
                        users.email,
                        roles.name as role,
                        users.telpon,
                        convertnumericdatetoalphabetical(users.created_at::date) as tanggal_dibuat
                    from users
                        inner join model_has_roles on users.id = model_has_roles.model_id and model_has_roles.model_type = 'App\Models\User'
                        inner join roles on model_has_roles.role_id = roles.id                
                ) as x
            ")
        );

        $nama = User::select(DB::raw('name AS value, name as label, count(*) AS count, count(*) as total'))
            ->distinct('name')
            ->groupBy('name')
            ->get();

        $email = User::select(DB::raw('email AS value, email as label, count(*) AS count, count(*) as total'))
            ->distinct('email')
            ->groupBy('email')
            ->get();

        $role = DB::select("
            select roles.name as value, roles.name as label, count(*) AS count, count(*) as total
            from users
                inner join model_has_roles on users.id = model_has_roles.model_id and model_has_roles.model_type = 'App\Models\User'
                inner join roles on model_has_roles.role_id = roles.id                
            group by roles.name
        ");

        return DataTables::of($query)->searchPane('name', $nama)->searchPane('email', $email)->searchPane('role', $role)->toJson();
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
                'message' => message('Pengguna gagal dibuat', $th->getMessage())
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
