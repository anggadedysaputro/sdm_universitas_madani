<?php

namespace App\Http\Controllers\Settings\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Logger\TraitsLoggerActivity;
use App\Traits\Yajra\Search\TraitsYajraSearch;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class SettingsPermission extends Controller
{
    use TraitsYajraSearch, TraitsLoggerActivity;
    public function index()
    {
        return view('settings.permission.index');
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            $permissionName = request('nama');

            Permission::create(['name' => $permissionName]);

            $this->activity("Input permission [successfully]");

            DB::commit();

            $response = [
                'message' => 'Input permission success'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input permission [failed]", $th->getMessage());

            $response = [
                'message' => 'Input permission failed'
            ];

            return response()->json($response, 500);
        }
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
        $model = Permission::from("permissions as p")
            ->select(
                "name",
                "id",
                DB::raw("convertnumericdatetoalphabetical(created_at::date) as created_at_view"),
                DB::raw("
                    json_build_object('nama',
                        (
                            select json_agg(r.name)
                            from role_has_permissions rhp
                            join roles r on rhp.role_id = r.id
                            where permission_id = p.id
                        )
                    ) assign
                ")
            );
        return $model;
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $id = request('id');
            Permission::find($id)->delete();
            $this->activity("Hapus izin [successfully]");

            DB::commit();

            $response = [
                'message' => 'Hapus izin berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Hapus izin [failed]", $th->getMessage());
            $response = [
                'message' => message("Hapus izin gagal", $th->getMessage())
            ];
            return response()->json($response, 500);
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $id = request('id');
            $name = request('nama');

            Permission::find($id)->update([
                'name' => $name
            ]);

            $this->activity("Mengubah izin [successfully]");
            DB::commit();

            $response = [
                'message' => 'Mengubah izin berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->activity("Mengubah izin [failed]", $th->getMessage());
            $response = [
                'message' => message("Mengubah izin gagal", $th->getMessage())
            ];
            return response()->json($response, 500);
        }
    }
}
