<?php

use App\Http\Controllers\Api\Auth;
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
});

Route::post('login', [Auth::class, 'login'])->name("login");
Route::post('logout', [Auth::class, 'logout'])->name("logout");
