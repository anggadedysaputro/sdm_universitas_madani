<?php

use App\Events\JoinConnection;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Jstree\Menu\JstreeMenu;
use App\Http\Controllers\Jstree\StrukturOrganisasi\JstreeStrukturOrganisasi;
use App\Http\Controllers\Karyawan\Add\KaryawanAdd;
use App\Http\Controllers\Karyawan\Karyawan;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Settings\Logo\SettingsLogo;
use App\Http\Controllers\Settings\Masters\Jabatan\Fungsional\SettingsMastersJabatanFungsional;
use App\Http\Controllers\Settings\Masters\Jabatan\Struktural\SettingsMastersJabatanStruktural;
use App\Http\Controllers\Settings\Masters\StatusPegawai\SettingsMastersStatusPegawai;
use App\Http\Controllers\Settings\Masters\SubUnit\SettingsMastersSubunit;
use App\Http\Controllers\Settings\Menu\SettingsMenu;
use App\Http\Controllers\Settings\Permission\SettingsPermission;
use App\Http\Controllers\Settings\Role\SettingsRole;
use App\Http\Controllers\Settings\StrukturOrganisasi\SettingsStrukturOrganisasi;
use App\Http\Controllers\Settings\User\SettingsUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('login')->group(function () {
    Route::get('index', [Login::class, 'index'])->name('login')->middleware('prevent.login');
    Route::post('authenticate', [Login::class, 'authenticate'])->name('login.authenticate');
});

Route::get('logout', [Logout::class, 'logout'])->name('logout');

Route::middleware(['validate.login'])->group(function () {

    Route::get('index', [Dashboard::class, 'index'])->name('dashboard.index')->middleware('permission:dashboard_lihat');

    Route::prefix('jstree')->group(function () {
        Route::prefix('menu')->group(function () {
            Route::post('data', [JstreeMenu::class, 'data'])->name('jstree.menu.data');
        });
        Route::prefix('struktur-organisasi')->group(function () {
            Route::post('data', [JstreeStrukturOrganisasi::class, 'data'])->name('jstree.struktur-organisasi.data');
        });
    });

    Route::prefix('settings')->group(function () {
        Route::prefix('menu')->group(function () {
            Route::get('index', [SettingsMenu::class, 'index'])->name('settings.menu.index')->middleware('permission:menu_lihat');
            Route::post('icon', [SettingsMenu::class, 'icon'])->name('settings.menu.icon');
            Route::post('byid', [SettingsMenu::class, 'byID'])->name('settings.menu.byid');
            Route::post('parent', [SettingsMenu::class, 'parent'])->name('settings.menu.parent');
            Route::post('link', [SettingsMenu::class, 'link'])->name('settings.menu.link');
            Route::post('store', [SettingsMenu::class, 'store'])->name('settings.menu.store')->middleware('permission:menu_tambah');
            Route::patch('edit', [SettingsMenu::class, 'edit'])->name('settings.menu.edit')->middleware('permission:menu_edit');
            Route::delete('delete', [SettingsMenu::class, 'delete'])->name('settings.menu.delete')->middleware('permission:menu_hapus');
        });
        Route::prefix('permission')->group(function () {
            Route::get('index', [SettingsPermission::class, 'index'])->name('settings.permission.index')->middleware('permission:permission_lihat');
            Route::post('all', [SettingsPermission::class, 'all'])->name('settings.permission.all');
            Route::post('create', [SettingsPermission::class, 'create'])->name('settings.permission.create')->middleware('permission:permission_tambah');
            Route::put('update', [SettingsPermission::class, 'update'])->name('settings.permission.update')->middleware('permission:permission_edit');
            Route::delete('delete', [SettingsPermission::class, 'delete'])->name('settings.permission.delete')->middleware('permission:permission_hapus');
        });
        Route::prefix('role')->group(function () {
            Route::get('index', [SettingsRole::class, 'index'])->name('settings.role.index')->middleware('permission:role_lihat');
            Route::post('create', [SettingsRole::class, 'create'])->name('settings.role.create')->middleware('permission:role_tambah');
            Route::put('update', [SettingsRole::class, 'update'])->name('settings.role.update')->middleware('permission:role_edit');
            Route::delete('delete', [SettingsRole::class, 'delete'])->name('settings.role.delete')->middleware('permission:role_hapus');
            Route::post('mypermission', [SettingsRole::class, 'mypermission'])->name('settings.role.mypermission');
        });
        Route::prefix('user')->group(function () {
            Route::get('index', [SettingsUser::class, 'index'])->name('settings.user.index')->middleware('permission:user_lihat');
            Route::post('all', [SettingsUser::class, 'all'])->name('settings.user.all');
            Route::post('store', [SettingsUser::class, 'store'])->name('settings.user.store')->middleware('permission:user_tambah');
            Route::put('update', [SettingsUser::class, 'update'])->name('settings.user.update')->middleware('permission:user_edit');
            Route::delete('delete', [SettingsUser::class, 'delete'])->name('settings.user.delete')->middleware('permission:user_hapus');
        });
        Route::prefix('logo')->group(function () {
            Route::get('index', [SettingsLogo::class, 'index'])->name('settings.logo.index')->middleware('permission:logo_lihat');
            Route::post('store', [SettingsLogo::class, 'store'])->name('settings.logo.store')->middleware('permission:logo_tambah');
            Route::delete('delete', [SettingsLogo::class, 'delete'])->name('settings.logo.delete')->middleware('permission:logo_hapus');
        });
        Route::prefix('masters')->group(function () {
            Route::prefix('sub-unit')->group(function () {
                Route::get('index', [SettingsMastersSubunit::class, 'index'])->name('settings.masters.sub-unit.index');
            });
            Route::prefix('jabatan')->group(function () {
                Route::prefix('struktural')->group(function () {
                    Route::get('index', [SettingsMastersJabatanStruktural::class, 'index'])->name('settings.masters.jabatan.struktural.index')->middleware('permission:jabatan struktural_lihat');
                    Route::post('store', [SettingsMastersJabatanStruktural::class, 'store'])->name('settings.masters.jabatan.struktural.store')->middleware('permission:jabatan struktural_tambah');
                    Route::delete('delete', [SettingsMastersJabatanStruktural::class, 'delete'])->name('settings.masters.jabatan.struktural.delete')->middleware('permission:jabatan struktural_hapus');
                    Route::patch('edit', [SettingsMastersJabatanStruktural::class, 'edit'])->name('settings.masters.jabatan.struktural.edit')->middleware('permission:jabatan struktural_edit');
                    Route::post('data', [SettingsMastersJabatanStruktural::class, 'data'])->name('settings.masters.jabatan.struktural.data');
                });
                Route::prefix('fungsional')->group(function () {
                    Route::get('index', [SettingsMastersJabatanFungsional::class, 'index'])->name('settings.masters.jabatan.fungsional.index')->middleware('permission:jabatan fungsional_lihat');
                    Route::post('store', [SettingsMastersJabatanFungsional::class, 'store'])->name('settings.masters.jabatan.fungsional.store')->middleware('permission:jabatan fungsional_tambah');
                    Route::delete('delete', [SettingsMastersJabatanFungsional::class, 'delete'])->name('settings.masters.jabatan.fungsional.delete')->middleware('permission:jabatan fungsional_hapus');
                    Route::patch('edit', [SettingsMastersJabatanFungsional::class, 'edit'])->name('settings.masters.jabatan.fungsional.edit')->middleware('permission:jabatan fungsional_edit');
                    Route::post('data', [SettingsMastersJabatanFungsional::class, 'data'])->name('settings.masters.jabatan.fungsional.data');
                });
            });
            Route::prefix('status-pegawai')->group(function () {
                Route::get('index', [SettingsMastersStatusPegawai::class, 'index'])->name('settings.masters.status-pegawai.index')->middleware('permission:status pegawai_lihat');
                Route::post('store', [SettingsMastersStatusPegawai::class, 'store'])->name('settings.masters.status-pegawai.store')->middleware('permission:status pegawai_tambah');
                Route::delete('delete', [SettingsMastersStatusPegawai::class, 'delete'])->name('settings.masters.status-pegawai.delete')->middleware('permission:status pegawai_hapus');
                Route::patch('edit', [SettingsMastersStatusPegawai::class, 'edit'])->name('settings.masters.status-pegawai.edit')->middleware('permission:status pegawai_edit');
                Route::post('data', [SettingsMastersStatusPegawai::class, 'data'])->name('settings.masters.status-pegawai.data');
            });
        });
        Route::prefix('struktur-organisasi')->group(function () {
            Route::get('index', [SettingsStrukturOrganisasi::class, 'index'])->name('settings.struktur-organisasi.index')->middleware('permission:struktur organisasi_lihat');
            Route::post('bidang', [SettingsStrukturOrganisasi::class, 'bidang'])->name('settings.struktur-organisasi.bidang');
            Route::post('simpan', [SettingsStrukturOrganisasi::class, 'simpan'])->name('settings.struktur-organisasi.simpan')->middleware('permission:struktur organisasi_tambah');
            Route::post('urai', [SettingsStrukturOrganisasi::class, 'urai'])->name('settings.struktur-organisasi.urai');
            Route::delete('simpan', [SettingsStrukturOrganisasi::class, 'delete'])->name('settings.struktur-organisasi.delete')->middleware('permission:struktur organisasi_hapus');
            Route::patch('edit', [SettingsStrukturOrganisasi::class, 'edit'])->name('settings.struktur-organisasi.edit')->middleware('permission:struktur organisasi_edit');;
        });
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('index', [Karyawan::class, 'index'])->name('karyawan.index');
        Route::prefix('add')->group(function () {
            Route::get('index', [KaryawanAdd::class, 'index'])->name('karyawan.add.index');
        });
    });
    Route::get('/su', function () {
        event(new JoinConnection());
    });
});
