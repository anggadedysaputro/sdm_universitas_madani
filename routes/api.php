<?php

use App\Http\Controllers\Api\Approval\Cuti\ApiApprovalCuti;
use App\Http\Controllers\Api\Approval\Ijin\ApiApprovalIjin;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\Cuti\ApiCuti;
use App\Http\Controllers\Api\Ijin\ApiIjin;
use App\Http\Controllers\Api\Jabatan\Struktural\ApiJabatanStruktural;
use App\Http\Controllers\Api\Kantor\ApiKantor;
use App\Http\Controllers\Api\Libur\ApiLibur;
use App\Http\Controllers\Api\Pegawai\ApiPegawai;
use App\Http\Controllers\Api\Presensi\ApiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['jwt.refreshtoken'])->get('refresh-token', [Auth::class, 'refresh'])->name("api.refresh-token");
Route::middleware(['jwt.verify'])->group(function () {
    Route::post('me', [Auth::class, 'me'])->name("api.me");
});

Route::prefix('pegawai')->group(function () {
    Route::post('/', [ApiPegawai::class, 'data'])->name('api.pegawai.data');
    Route::post('/upload-foto', [ApiPegawai::class, 'uploadFoto'])->name('api.pegawai.upload-foto');
});
Route::prefix('presensi')->group(function () {
    Route::post('/create', [ApiPresensi::class, 'create'])->name('api.presensi.create');
    Route::post('/data', [ApiPresensi::class, 'data'])->name('api.presensi.data');
    Route::post('/detail', [ApiPresensi::class, 'detail'])->name('api.presensi.detail');
    Route::post('/laporan', [ApiPresensi::class, 'laporan'])->name('api.presensi.laporan');
});
Route::prefix('cuti')->group(function () {
    Route::post('/create', [ApiCuti::class, 'create'])->name('api.cuti.create');
    Route::post('/data', [ApiCuti::class, 'data'])->name('api.cuti.data');
});
Route::prefix('ijin')->group(function () {
    Route::post('/create', [ApiIjin::class, 'create'])->name('api.ijin.create');
    Route::post('/data', [ApiIjin::class, 'data'])->name('api.ijin.data');
});
Route::prefix('kantor')->group(function () {
    Route::post('/create', [ApiKantor::class, 'create'])->name('api.kantor.create');
});
Route::prefix('libur')->group(function () {
    Route::get('/data', [ApiLibur::class, 'data'])->name('api.libur.data');
});
Route::prefix('jabatan')->group(function () {
    Route::prefix('struktural')->group(function () {
        Route::get('/data', [ApiJabatanStruktural::class, 'data'])->name('api.jabatan.struktural.data');
    });
});
Route::prefix('approval')->group(function () {
    Route::prefix('cuti')->group(function () {
        Route::post('/data', [ApiApprovalCuti::class, 'data'])->name('api.approval.cuti.data');
    });
    Route::prefix('ijin')->group(function () {
        Route::post('/data', [ApiApprovalIjin::class, 'data'])->name('api.approval.ijin.data');
    });
});
Route::post('login', [Auth::class, 'login'])->name("login");
Route::post('logout', [Auth::class, 'logout'])->name("logout");
