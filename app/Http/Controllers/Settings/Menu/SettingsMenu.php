<?php

namespace App\Http\Controllers\Settings\Menu;

use App\Http\Controllers\Controller;
use App\Models\Masters\Icon;
use App\Models\Masters\Menu;
use App\Traits\Logger\TraitsLoggerActivity;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SettingsMenu extends Controller
{
    use TraitsLoggerActivity;

    public function index()
    {
        return view('settings.menu.index');
    }

    public function icon()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;
        $query = Icon::select("id", "nama as text", DB::raw("sum(1)over() as total"), "nama as icon")->take($resultCount)->skip($offset);

        $sql = "nama ilike ?";
        if (request('search')) $query->whereRaw($sql, ["%" . request('search') . "%"]);

        $result = $query->get()->toArray();

        $total = 0;
        if (count($result) > 0) $total = $result[0]['total'];


        $morePages = !($resultCount >= $total);

        $response = array(
            "results" => $result,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($response, 200);
    }

    public function parent()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $offset = ($page - 1) * $resultCount;
        $query = Menu::select("id", "nama as text", DB::raw("sum(1)over() as total"))->take($resultCount)->skip($offset);

        $sql = "nama ilike ?";
        if (request('search')) $query->whereRaw($sql, ["%" . request('search') . "%"]);

        $result = $query->get()->toArray();

        $total = 0;
        if (count($result) > 0) $total = $result[0]['total'];


        $morePages = !($resultCount >= $total);

        $response = array(
            "results" => $result,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($response, 200);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function link()
    {
        $morePages = true;
        $resultCount = 10;
        $page = request('page');
        $allRoutes = [];
        foreach (Route::getRoutes() as $key => $value) {
            if ($value->methods()[0] === "GET" && !empty($value->getName())) {
                if (in_array("index", explode(".", $value->getName()))) array_push($allRoutes, ["id" => $value->getName(), "text" => $value->getName(), "link" => $value->getName()]);
            }
        }

        $query = $this->paginate($allRoutes, $resultCount, $page);

        if (request('search')) {
            $cari = request('search');
            $filtered = $query->filter(function ($value, $key) use ($cari) {
                return str_contains($value['link'], $cari);
            });
            $result = [];
            foreach ($filtered->all() as $key => $value) {
                array_push($result, $value);
            }
        } else {
            $result = array_values($query->toArray()['data']);
        }

        $morePages = !($query->currentPage() == $query->lastPage());

        $response = array(
            "results" => $result,
            "pagination" => array(
                "more" => $morePages
            )
        );

        return response()->json($response, 200);
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();
            if (!isset($post['icon'])) $post['icon'] = 0;
            if (!isset($post['parent'])) $post['parent'] = 0;
            $post['icon_id'] = $post['icon'];

            unset($post['id']);

            Menu::create($post);

            $this->activity("Input data menu [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Input data menu berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Input data menu [failed]", $th->getMessage());

            $response = [
                'message' => message("Input data menu gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function edit()
    {
        DB::beginTransaction();
        try {
            $post = request()->all();

            if (!isset($post['icon'])) $post['icon'] = 0;
            if (!isset($post['parent'])) $post['parent'] = 0;
            $post['icon_id'] = $post['icon'];
            $id = $post['id'];
            unset($post['id']);

            Menu::find($id)->update($post);

            $this->activity("Edit data menu [successfully]");

            // dd(getSql($x));
            DB::commit();

            $response = [
                'message' => 'Edit data menu berhasil'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Edit data menu [failed]", $th->getMessage());

            $response = [
                'message' => message("Edit data menu gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function delete()
    {
        DB::beginTransaction();
        try {
            $idMenu = request('id');

            // hapus induknya lalu hapus anaknya
            Menu::find($idMenu)->delete();
            Menu::where('parent', $idMenu)->delete();

            DB::commit();

            $response = [
                'message' => 'Berhasil menghapus data'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->activity("Hapus data menu [failed]", $th->getMessage());

            $response = [
                'message' => message("Hapus data menu gagal", $th->getMessage())
            ];

            return response()->json($response, 500);
        }
    }

    public function byID()
    {
        try {

            $query = Menu::select(
                DB::raw("menu.*"),
                DB::raw("masters.icon.nama as icon_name"),
                DB::raw("(select nama from masters.menu as j where j.id = menu.parent) parent_name")
            )
                ->join("masters.icon", "masters.icon.id", "=", "menu.icon_id")->where('menu.id', request('id'));

            $response = [
                'message' => 'Berhasil mengambil menu by id',
                'data' => $query->first()
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'message' => 'Gagal mengambil menu by id'
            ];

            return response()->json($response, 500);
        }
    }
}
