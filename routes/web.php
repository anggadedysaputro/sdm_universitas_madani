<?php

use App\Events\JoinConnection;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Jstree\Menu\JstreeMenu;
use App\Http\Controllers\Jstree\StrukturOrganisasi\JstreeStrukturOrganisasi;
use App\Http\Controllers\Karyawan\Add\KaryawanAdd;
use App\Http\Controllers\Karyawan\Edit\KaryawanEdit;
use App\Http\Controllers\Karyawan\Karyawan;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Select2\Jabatan\Fungsional\Select2JabatanFungsional;
use App\Http\Controllers\Select2\Jabatan\Struktural\Select2JabatanStruktural;
use App\Http\Controllers\Settings\Logo\SettingsLogo;
use App\Http\Controllers\Settings\Masters\Jabatan\Fungsional\SettingsMastersJabatanFungsional;
use App\Http\Controllers\Settings\Masters\Jabatan\Struktural\SettingsMastersJabatanStruktural;
use App\Http\Controllers\Settings\Masters\KartuIdentitas\SettingsMastersKartuIdentitas;
use App\Http\Controllers\Settings\Masters\Libur\SettingsMastersLibur;
use App\Http\Controllers\Settings\Masters\Negara\SettingsMastersNegara;
use App\Http\Controllers\Settings\Masters\Pendidikan\SettingsMastersPendidikan;
use App\Http\Controllers\Settings\Masters\StatusIjin\SettingsMastersStatusIjin;
use App\Http\Controllers\Settings\Masters\StatusPegawai\SettingsMastersStatusPegawai;
use App\Http\Controllers\Settings\Masters\StrukturOrganisasi\SettingsMastersStrukturOrganisasi;
use App\Http\Controllers\Settings\Masters\SubUnit\SettingsMastersSubunit;
use App\Http\Controllers\Settings\Menu\SettingsMenu;
use App\Http\Controllers\Settings\Permission\SettingsPermission;
use App\Http\Controllers\Settings\Role\SettingsRole;
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

    Route::prefix('select2')->group(function () {
        Route::prefix('jabatan')->group(function () {
            Route::prefix('fungsional')->group(function () {
                Route::post('data', [Select2JabatanFungsional::class, 'data'])->name('select2.jabatan.fungsional.data');
            });
            Route::prefix('struktural')->group(function () {
                Route::post('data', [Select2JabatanStruktural::class, 'data'])->name('select2.jabatan.struktural.data');
            });
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
            Route::prefix('pendidikan')->group(function () {
                Route::get('index', [SettingsMastersPendidikan::class, 'index'])->name('settings.masters.pendidikan.index')->middleware('permission:pendidikan_lihat');
                Route::post('store', [SettingsMastersPendidikan::class, 'store'])->name('settings.masters.pendidikan.store')->middleware('permission:pendidikan_tambah');
                Route::delete('delete', [SettingsMastersPendidikan::class, 'delete'])->name('settings.masters.pendidikan.delete')->middleware('permission:pendidikan_hapus');
                Route::patch('edit', [SettingsMastersPendidikan::class, 'edit'])->name('settings.masters.pendidikan.edit')->middleware('permission:pendidikan_edit');
                Route::post('data', [SettingsMastersPendidikan::class, 'data'])->name('settings.masters.pendidikan.data');
            });
            Route::prefix('status-ijin')->group(function () {
                Route::get('index', [SettingsMastersStatusIjin::class, 'index'])->name('settings.masters.status-ijin.index')->middleware('permission:status ijin_lihat');
                Route::post('store', [SettingsMastersStatusIjin::class, 'store'])->name('settings.masters.status-ijin.store')->middleware('permission:status ijin_tambah');
                Route::delete('delete', [SettingsMastersStatusIjin::class, 'delete'])->name('settings.masters.status-ijin.delete')->middleware('permission:status ijin_hapus');
                Route::patch('edit', [SettingsMastersStatusIjin::class, 'edit'])->name('settings.masters.status-ijin.edit')->middleware('permission:status ijin_edit');
                Route::post('data', [SettingsMastersStatusIjin::class, 'data'])->name('settings.masters.status-ijin.data');
            });
            Route::prefix('libur')->group(function () {
                Route::get('index', [SettingsMastersLibur::class, 'index'])->name('settings.masters.libur.index')->middleware('permission:libur_lihat');
                Route::post('store', [SettingsMastersLibur::class, 'store'])->name('settings.masters.libur.store')->middleware('permission:libur_tambah');
                Route::delete('delete', [SettingsMastersLibur::class, 'delete'])->name('settings.masters.libur.delete')->middleware('permission:libur_hapus');
                Route::patch('edit', [SettingsMastersLibur::class, 'edit'])->name('settings.masters.libur.edit')->middleware('permission:libur_edit');
                Route::post('data', [SettingsMastersLibur::class, 'data'])->name('settings.masters.libur.data');
            });
            Route::prefix('negara')->group(function () {
                Route::get('index', [SettingsMastersNegara::class, 'index'])->name('settings.masters.negara.index')->middleware('permission:negara_lihat');
                Route::post('store', [SettingsMastersNegara::class, 'store'])->name('settings.masters.negara.store')->middleware('permission:negara_tambah');
                Route::delete('delete', [SettingsMastersNegara::class, 'delete'])->name('settings.masters.negara.delete')->middleware('permission:negara_hapus');
                Route::patch('edit', [SettingsMastersNegara::class, 'edit'])->name('settings.masters.negara.edit')->middleware('permission:negara_edit');
                Route::post('data', [SettingsMastersNegara::class, 'data'])->name('settings.masters.negara.data');
            });
            Route::prefix('struktur-organisasi')->group(function () {
                Route::get('index', [SettingsMastersStrukturOrganisasi::class, 'index'])->name('settings.masters.struktur-organisasi.index')->middleware('permission:struktur organisasi_lihat');
                Route::post('bidang', [SettingsMastersStrukturOrganisasi::class, 'bidang'])->name('settings.masters.struktur-organisasi.bidang');
                Route::post('simpan', [SettingsMastersStrukturOrganisasi::class, 'simpan'])->name('settings.masters.struktur-organisasi.simpan')->middleware('permission:struktur organisasi_tambah');
                Route::post('urai', [SettingsMastersStrukturOrganisasi::class, 'urai'])->name('settings.masters.struktur-organisasi.urai');
                Route::delete('simpan', [SettingsMastersStrukturOrganisasi::class, 'delete'])->name('settings.masters.struktur-organisasi.delete')->middleware('permission:struktur organisasi_hapus');
                Route::patch('edit', [SettingsMastersStrukturOrganisasi::class, 'edit'])->name('settings.masters.struktur-organisasi.edit')->middleware('permission:struktur organisasi_edit');;
            });
            Route::prefix('kartu-identitas')->group(function () {
                Route::get('index', [SettingsMastersKartuIdentitas::class, 'index'])->name('settings.masters.kartu-identitas.index')->middleware('permission:kartu identitas_lihat');
                Route::post('store', [SettingsMastersKartuIdentitas::class, 'store'])->name('settings.masters.kartu-identitas.store')->middleware('permission:kartu identitas_tambah');
                Route::delete('delete', [SettingsMastersKartuIdentitas::class, 'delete'])->name('settings.masters.kartu-identitas.delete')->middleware('permission:kartu identitas_hapus');
                Route::patch('edit', [SettingsMastersKartuIdentitas::class, 'edit'])->name('settings.masters.kartu-identitas.edit')->middleware('permission:kartu identitas_edit');
                Route::post('data', [SettingsMastersKartuIdentitas::class, 'data'])->name('settings.masters.kartu-identitas.data');
            });
        });
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('index', [Karyawan::class, 'index'])->name('karyawan.index');
        Route::post('data', [Karyawan::class, 'data'])->name('karyawan.data');
        Route::prefix('add')->group(function () {
            Route::get('index', [KaryawanAdd::class, 'index'])->name('karyawan.add.index');
            Route::post('store', [KaryawanAdd::class, 'store'])->name('karyawan.add.store');
        });
        Route::prefix('edit')->group(function () {
            Route::get('index/{id}', [KaryawanEdit::class, 'index'])->name('karyawan.edit.index');
            Route::patch('store', [KaryawanEdit::class, 'store'])->name('karyawan.edit.store');
        });
    });
    Route::get('/su', function () {
        event(new JoinConnection());
    });
});
