<?php

use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\Pegawai\ApiPegawai;
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
    Route::post('data', [ApiPegawai::class, 'data'])->name('api.pegawai.data');
});
Route::post('login', [Auth::class, 'login'])->name("login");
Route::post('logout', [Auth::class, 'logout'])->name("logout");
