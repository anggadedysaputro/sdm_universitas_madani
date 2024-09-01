<?php

use App\Events\JoinConnection;
use App\Http\Controllers\Cuti\Cuti;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Jstree\Menu\JstreeMenu;
use App\Http\Controllers\Jstree\StrukturOrganisasi\JstreeStrukturOrganisasi;
use App\Http\Controllers\Karyawan\Add\KaryawanAdd;
use App\Http\Controllers\Karyawan\Edit\KaryawanEdit;
use App\Http\Controllers\Karyawan\Karyawan;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Presensi\Presensi;
use App\Http\Controllers\Profile\Profile;
use App\Http\Controllers\Select2\Bidang\Divisi\Select2BidangDivisi;
use App\Http\Controllers\Select2\Bidang\Select2Bidang;
use App\Http\Controllers\Select2\Jabatan\Fungsional\Select2JabatanFungsional;
use App\Http\Controllers\Select2\Jabatan\Struktural\Select2JabatanStruktural;
use App\Http\Controllers\Select2\Kantor\Select2Kantor;
use App\Http\Controllers\Select2\Organisasi\Bidang\Select2OrganisasiBidang;
use App\Http\Controllers\Select2\Organisasi\Divisi\Select2OrganisasiDivisi;
use App\Http\Controllers\Select2\Organisasi\SubDivisi\Select2OrganisasiSubDivisi;
use App\Http\Controllers\Select2\Organisasi\SubSubDivisi\Select2OrganisasiSubSubDivisi;
use App\Http\Controllers\Settings\ConfigApp\SettingsConfigApp;
use App\Http\Controllers\Settings\KonfigUmum\SettingsKonfigUmum;
use App\Http\Controllers\Settings\Logo\SettingsLogo;
use App\Http\Controllers\Settings\Masters\Jabatan\Fungsional\SettingsMastersJabatanFungsional;
use App\Http\Controllers\Settings\Masters\Jabatan\Struktural\SettingsMastersJabatanStruktural;
use App\Http\Controllers\Settings\Masters\Kantor\SettingsMastersKantor;
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
| be assigned to the "web " middleware group. Make something great !
|
*/

Route::prefix('login')->group(function () {
    Route::get('index', [Login::class, 'index'])->name('login');
    Route::post('authenticate', [Login::class, 'authenticate'])->name('login.authenticate');
});

Route::get('logout', [Logout::class, 'logout'])->name('logout');

Route::middleware(['validate.login'])->group(function () {

    Route::get('/', [Dashboard::class, 'index'])->name('dashboard.index')->middleware(["initialize.menu"]);
    Route::get('index', [Dashboard::class, 'index'])->name('dashboard.index')->middleware(["initialize.menu"]);

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
        Route::prefix('kantor')->group(function () {
            Route::post('data', [Select2Kantor::class, 'data'])->name('select2.kantor.data');
        });
        Route::prefix('organisasi')->group(function () {
            Route::prefix('bidang')->group(function () {
                Route::post('data', [Select2OrganisasiBidang::class, 'data'])->name('select2.organisasi.bidang.data');
            });
            Route::prefix('divisi')->group(function () {
                Route::post('data', [Select2OrganisasiDivisi::class, 'data'])->name('select2.organisasi.divisi.data');
            });
            Route::prefix('sub-divisi')->group(function () {
                Route::post('data', [Select2OrganisasiSubDivisi::class, 'data'])->name('select2.organisasi.sub-divisi.data');
            });
            Route::prefix('sub-sub-divisi')->group(function () {
                Route::post('data', [Select2OrganisasiSubSubDivisi::class, 'data'])->name('select2.organisasi.sub-sub-divisi.data');
            });
        });
    });

    Route::prefix('settings')->group(function () {
        Route::prefix('menu')->group(function () {
            Route::get('index', [SettingsMenu::class, 'index'])->name('settings.menu.index')->middleware(["initialize.menu"]);
            Route::post('icon', [SettingsMenu::class, 'icon'])->name('settings.menu.icon');
            Route::post('byid', [SettingsMenu::class, 'byID'])->name('settings.menu.byid');
            Route::post('parent', [SettingsMenu::class, 'parent'])->name('settings.menu.parent');
            Route::post('link', [SettingsMenu::class, 'link'])->name('settings.menu.link');
            Route::post('store', [SettingsMenu::class, 'store'])->name('settings.menu.store');
            Route::patch('edit', [SettingsMenu::class, 'edit'])->name('settings.menu.edit');
            Route::delete('delete', [SettingsMenu::class, 'delete'])->name('settings.menu.delete');
        });
        Route::prefix('permission')->group(function () {
            Route::get('index', [SettingsPermission::class, 'index'])->name('settings.permission.index')->middleware(["initialize.menu"]);
            Route::post('data', [SettingsPermission::class, 'data'])->name('settings.permission.data');
            Route::post('single', [SettingsPermission::class, 'single'])->name('settings.permission.single');
            Route::post('create', [SettingsPermission::class, 'create'])->name('settings.permission.create');
            Route::put('update', [SettingsPermission::class, 'update'])->name('settings.permission.update');
            Route::delete('delete', [SettingsPermission::class, 'delete'])->name('settings.permission.delete');
        });
        Route::prefix('role')->group(function () {
            Route::get('index', [SettingsRole::class, 'index'])->name('settings.role.index')->middleware(["initialize.menu"]);
            Route::post('create', [SettingsRole::class, 'create'])->name('settings.role.create');
            Route::put('update', [SettingsRole::class, 'update'])->name('settings.role.update');
            Route::delete('delete', [SettingsRole::class, 'delete'])->name('settings.role.delete');
            Route::post('mypermission', [SettingsRole::class, 'mypermission'])->name('settings.role.mypermission');
            Route::post('full-akses', [SettingsRole::class, 'fullAkses'])->name('settings.role.full-akses');
        });
        Route::prefix('user')->group(function () {
            Route::get('index', [SettingsUser::class, 'index'])->name('settings.user.index')->middleware(["initialize.menu"]);
            Route::post('data', [SettingsUser::class, 'data'])->name('settings.user.data');
            Route::post('store', [SettingsUser::class, 'store'])->name('settings.user.store');
            Route::put('update', [SettingsUser::class, 'update'])->name('settings.user.update');
            Route::delete('delete', [SettingsUser::class, 'delete'])->name('settings.user.delete');
        });
        Route::prefix('logo')->group(function () {
            Route::get('index', [SettingsLogo::class, 'index'])->name('settings.logo.index')->middleware(["initialize.menu"]);
            Route::post('store', [SettingsLogo::class, 'store'])->name('settings.logo.store');
            Route::delete('delete', [SettingsLogo::class, 'delete'])->name('settings.logo.delete');
        });
        Route::prefix('konfig-umum')->group(function () {
            Route::get('index', [SettingsKonfigUmum::class, 'index'])->name('settings.konfig-umum.index')->middleware(["initialize.menu"]);
            Route::post('store', [SettingsKonfigUmum::class, 'store'])->name('settings.konfig-umum.store');
            Route::delete('delete', [SettingsKonfigUmum::class, 'delete'])->name('settings.konfig-umum.delete');
            Route::patch('edit', [SettingsKonfigUmum::class, 'edit'])->name('settings.konfig-umum.edit');
            Route::post('data', [SettingsKonfigUmum::class, 'data'])->name('settings.konfig-umum.data');
        });
        Route::prefix('config-app')->group(function () {
            Route::get('index', [SettingsConfigApp::class, 'index'])->name('settings.config-app.index')->middleware(["initialize.menu"]);
            Route::post('store', [SettingsConfigApp::class, 'store'])->name('settings.config-app.store');
            Route::delete('delete', [SettingsConfigApp::class, 'delete'])->name('settings.config-app.delete');
            Route::patch('edit', [SettingsConfigApp::class, 'edit'])->name('settings.config-app.edit');
            Route::post('data', [SettingsConfigApp::class, 'data'])->name('settings.config-app.data');
        });


        Route::prefix('masters')->group(function () {
            Route::prefix('sub-unit')->group(function () {
                Route::get('index', [SettingsMastersSubunit::class, 'index'])->name('settings.masters.sub-unit.index')->middleware(["initialize.menu"]);
            });
            Route::prefix('jabatan')->group(function () {
                Route::prefix('struktural')->group(function () {
                    Route::get('index', [SettingsMastersJabatanStruktural::class, 'index'])->name('settings.masters.jabatan.struktural.index')->middleware(["initialize.menu"]);
                    Route::post('store', [SettingsMastersJabatanStruktural::class, 'store'])->name('settings.masters.jabatan.struktural.store');
                    Route::delete('delete', [SettingsMastersJabatanStruktural::class, 'delete'])->name('settings.masters.jabatan.struktural.delete');
                    Route::patch('edit', [SettingsMastersJabatanStruktural::class, 'edit'])->name('settings.masters.jabatan.struktural.edit');
                    Route::post('data', [SettingsMastersJabatanStruktural::class, 'data'])->name('settings.masters.jabatan.struktural.data');
                });
                Route::prefix('fungsional')->group(function () {
                    Route::get('index', [SettingsMastersJabatanFungsional::class, 'index'])->name('settings.masters.jabatan.fungsional.index')->middleware(["initialize.menu"]);
                    Route::post('store', [SettingsMastersJabatanFungsional::class, 'store'])->name('settings.masters.jabatan.fungsional.store');
                    Route::delete('delete', [SettingsMastersJabatanFungsional::class, 'delete'])->name('settings.masters.jabatan.fungsional.delete');
                    Route::patch('edit', [SettingsMastersJabatanFungsional::class, 'edit'])->name('settings.masters.jabatan.fungsional.edit');
                    Route::post('data', [SettingsMastersJabatanFungsional::class, 'data'])->name('settings.masters.jabatan.fungsional.data');
                });
            });
            Route::prefix('status-pegawai')->group(function () {
                Route::get('index', [SettingsMastersStatusPegawai::class, 'index'])->name('settings.masters.status-pegawai.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersStatusPegawai::class, 'store'])->name('settings.masters.status-pegawai.store');
                Route::delete('delete', [SettingsMastersStatusPegawai::class, 'delete'])->name('settings.masters.status-pegawai.delete');
                Route::patch('edit', [SettingsMastersStatusPegawai::class, 'edit'])->name('settings.masters.status-pegawai.edit');
                Route::post('data', [SettingsMastersStatusPegawai::class, 'data'])->name('settings.masters.status-pegawai.data');
            });
            Route::prefix('pendidikan')->group(function () {
                Route::get('index', [SettingsMastersPendidikan::class, 'index'])->name('settings.masters.pendidikan.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersPendidikan::class, 'store'])->name('settings.masters.pendidikan.store');
                Route::delete('delete', [SettingsMastersPendidikan::class, 'delete'])->name('settings.masters.pendidikan.delete');
                Route::patch('edit', [SettingsMastersPendidikan::class, 'edit'])->name('settings.masters.pendidikan.edit');
                Route::post('data', [SettingsMastersPendidikan::class, 'data'])->name('settings.masters.pendidikan.data');
            });
            Route::prefix('status-ijin')->group(function () {
                Route::get('index', [SettingsMastersStatusIjin::class, 'index'])->name('settings.masters.status-ijin.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersStatusIjin::class, 'store'])->name('settings.masters.status-ijin.store');
                Route::delete('delete', [SettingsMastersStatusIjin::class, 'delete'])->name('settings.masters.status-ijin.delete');
                Route::patch('edit', [SettingsMastersStatusIjin::class, 'edit'])->name('settings.masters.status-ijin.edit');
                Route::post('data', [SettingsMastersStatusIjin::class, 'data'])->name('settings.masters.status-ijin.data');
            });
            Route::prefix('libur')->group(function () {
                Route::get('index', [SettingsMastersLibur::class, 'index'])->name('settings.masters.libur.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersLibur::class, 'store'])->name('settings.masters.libur.store');
                Route::delete('delete', [SettingsMastersLibur::class, 'delete'])->name('settings.masters.libur.delete');
                Route::patch('edit', [SettingsMastersLibur::class, 'edit'])->name('settings.masters.libur.edit');
                Route::post('data', [SettingsMastersLibur::class, 'data'])->name('settings.masters.libur.data');
            });
            Route::prefix('negara')->group(function () {
                Route::get('index', [SettingsMastersNegara::class, 'index'])->name('settings.masters.negara.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersNegara::class, 'store'])->name('settings.masters.negara.store');
                Route::delete('delete', [SettingsMastersNegara::class, 'delete'])->name('settings.masters.negara.delete');
                Route::patch('edit', [SettingsMastersNegara::class, 'edit'])->name('settings.masters.negara.edit');
                Route::post('data', [SettingsMastersNegara::class, 'data'])->name('settings.masters.negara.data');
            });
            Route::prefix('struktur-organisasi')->group(function () {
                Route::get('index', [SettingsMastersStrukturOrganisasi::class, 'index'])->name('settings.masters.struktur-organisasi.index')->middleware(["initialize.menu"]);
                Route::post('bidang', [SettingsMastersStrukturOrganisasi::class, 'bidang'])->name('settings.masters.struktur-organisasi.bidang');
                Route::post('simpan', [SettingsMastersStrukturOrganisasi::class, 'simpan'])->name('settings.masters.struktur-organisasi.simpan');
                Route::post('urai', [SettingsMastersStrukturOrganisasi::class, 'urai'])->name('settings.masters.struktur-organisasi.urai');
                Route::delete('simpan', [SettingsMastersStrukturOrganisasi::class, 'delete'])->name('settings.masters.struktur-organisasi.delete');
                Route::patch('edit', [SettingsMastersStrukturOrganisasi::class, 'edit'])->name('settings.masters.struktur-organisasi.edit');
            });
            Route::prefix('kartu-identitas')->group(function () {
                Route::get('index', [SettingsMastersKartuIdentitas::class, 'index'])->name('settings.masters.kartu-identitas.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersKartuIdentitas::class, 'store'])->name('settings.masters.kartu-identitas.store');
                Route::delete('delete', [SettingsMastersKartuIdentitas::class, 'delete'])->name('settings.masters.kartu-identitas.delete');
                Route::patch('edit', [SettingsMastersKartuIdentitas::class, 'edit'])->name('settings.masters.kartu-identitas.edit');
                Route::post('data', [SettingsMastersKartuIdentitas::class, 'data'])->name('settings.masters.kartu-identitas.data');
            });
            Route::prefix('kantor')->group(function () {
                Route::get('index', [SettingsMastersKantor::class, 'index'])->name('settings.masters.kantor.index')->middleware(["initialize.menu"]);
                Route::post('store', [SettingsMastersKantor::class, 'store'])->name('settings.masters.kantor.store');
                Route::delete('delete', [SettingsMastersKantor::class, 'delete'])->name('settings.masters.kantor.delete');
                Route::patch('edit', [SettingsMastersKantor::class, 'edit'])->name('settings.masters.kantor.edit');
                Route::patch('setujui', [SettingsMastersKantor::class, 'setujui'])->name('settings.masters.kantor.setujui');
                Route::patch('tolak', [SettingsMastersKantor::class, 'tolak'])->name('settings.masters.kantor.tolak');
                Route::post('data', [SettingsMastersKantor::class, 'data'])->name('settings.masters.kantor.data');
            });
        });
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('index', [Karyawan::class, 'index'])->name('karyawan.index')->middleware(["initialize.menu"]);
        Route::post('data', [Karyawan::class, 'data'])->name('karyawan.data');
        Route::prefix('add')->group(function () {
            Route::get('index', [KaryawanAdd::class, 'index'])->name('karyawan.add.index')->middleware("permission:add karyawan");
            Route::post('store', [KaryawanAdd::class, 'store'])->name('karyawan.add.store');
        });
        Route::prefix('edit')->group(function () {
            Route::get('index/{id}', [KaryawanEdit::class, 'index'])->name('karyawan.edit.index')->middleware("permission:edit karyawan");;
            Route::patch('store', [KaryawanEdit::class, 'store'])->name('karyawan.edit.store');
            Route::post('upload', [KaryawanEdit::class, 'upload'])->name('karyawan.edit.upload');
        });
    });

    Route::prefix('cuti')->group(function () {
        Route::get('index', [Cuti::class, 'index'])->name('cuti.index')->middleware(["initialize.menu"]);
        Route::post('store', [Cuti::class, 'store'])->name('cuti.store');
        Route::post('data', [Cuti::class, 'data'])->name('cuti.data');
        Route::patch('edit', [Cuti::class, 'edit'])->name('cuti.edit');
        Route::delete('delete', [Cuti::class, 'delete'])->name('cuti.delete');
    });

    Route::prefix('profile')->group(function () {
        Route::get('index', [Profile::class, 'index'])->name('profile.index')->middleware(["initialize.menu"]);
    });

    Route::prefix('presensi')->group(function () {
        Route::get('index', [Presensi::class, 'index'])->name('presensi.index')->middleware(["initialize.menu"]);
        Route::post('data', [Presensi::class, 'data'])->name('presensi.data');
    });

    Route::get('/su', function () {
        event(new JoinConnection());
    });
});
