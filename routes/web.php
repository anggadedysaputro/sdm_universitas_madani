<?php

use App\Events\JoinConnection;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Jstree\Menu\JstreeMenu;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Settings\Logo\SettingsLogo;
use App\Http\Controllers\Settings\Masters\Jabatan\Fungsional\SettingsMastersJabatanFungsional;
use App\Http\Controllers\Settings\Masters\Jabatan\Struktural\SettingsMastersJabatanStruktural;
use App\Http\Controllers\Settings\Masters\SettingsMasters;
use App\Http\Controllers\Settings\Masters\SubUnit\SettingsMastersSubunit;
use App\Http\Controllers\Settings\Menu\SettingsMenu;
use App\Http\Controllers\Settings\Permission\SettingsPermission;
use App\Http\Controllers\Settings\Role\SettingsRole;
use App\Http\Controllers\Settings\Settings;
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

    Route::get('index', [Dashboard::class, 'index'])->name('dashboard.index');

    Route::prefix('jstree')->group(function () {
        Route::prefix('menu')->group(function () {
            Route::post('data', [JstreeMenu::class, 'data'])->name('jstree.menu.data');
        });
    });

    Route::prefix('settings')->group(function () {
        Route::prefix('menu')->group(function () {
            Route::get('index', [SettingsMenu::class, 'index'])->name('settings.menu.index');
            Route::post('icon', [SettingsMenu::class, 'icon'])->name('settings.menu.icon');
            Route::post('byid', [SettingsMenu::class, 'byID'])->name('settings.menu.byid');
            Route::post('parent', [SettingsMenu::class, 'parent'])->name('settings.menu.parent');
            Route::post('link', [SettingsMenu::class, 'link'])->name('settings.menu.link');
            Route::post('store', [SettingsMenu::class, 'store'])->name('settings.menu.store');
            Route::patch('edit', [SettingsMenu::class, 'edit'])->name('settings.menu.edit');
            Route::delete('delete', [SettingsMenu::class, 'delete'])->name('settings.menu.delete');
        });
        Route::prefix('permission')->group(function () {
            Route::get('index', [SettingsPermission::class, 'index'])->name('settings.permission.index');
            Route::post('all', [SettingsPermission::class, 'all'])->name('settings.permission.all');
            Route::post('create', [SettingsPermission::class, 'create'])->name('settings.permission.create');
            Route::put('update', [SettingsPermission::class, 'update'])->name('settings.permission.update');
            Route::delete('delete', [SettingsPermission::class, 'delete'])->name('settings.permission.delete');
        });
        Route::prefix('role')->group(function () {
            Route::get('index', [SettingsRole::class, 'index'])->name('settings.role.index');
            Route::post('create', [SettingsRole::class, 'create'])->name('settings.role.create');
            Route::put('update', [SettingsRole::class, 'update'])->name('settings.role.update');
            Route::delete('delete', [SettingsRole::class, 'delete'])->name('settings.role.delete');
            Route::post('mypermission', [SettingsRole::class, 'mypermission'])->name('settings.role.mypermission');
        });
        Route::prefix('user')->group(function () {
            Route::get('index', [SettingsUser::class, 'index'])->name('settings.user.index');
            Route::post('all', [SettingsUser::class, 'all'])->name('settings.user.all');
            Route::post('store', [SettingsUser::class, 'store'])->name('settings.user.store');
            Route::put('update', [SettingsUser::class, 'update'])->name('settings.user.update');
            Route::delete('delete', [SettingsUser::class, 'delete'])->name('settings.user.delete');
        });
        Route::prefix('logo')->group(function () {
            Route::get('index', [SettingsLogo::class, 'index'])->name('settings.logo.index');
        });
        Route::prefix('masters')->group(function () {
            Route::prefix('sub-unit')->group(function () {
                Route::get('index', [SettingsMastersSubunit::class, 'index'])->name('settings.masters.sub-unit.index');
            });
            Route::prefix('jabatan')->group(function () {
                Route::prefix('struktural')->group(function () {
                    Route::get('index', [SettingsMastersJabatanStruktural::class, 'index'])->name('settings.masters.jabatan.struktural.index');
                    Route::post('store', [SettingsMastersJabatanStruktural::class, 'store'])->name('settings.masters.jabatan.struktural.store');
                    Route::delete('delete', [SettingsMastersJabatanStruktural::class, 'delete'])->name('settings.masters.jabatan.struktural.delete');
                    Route::patch('edit', [SettingsMastersJabatanStruktural::class, 'edit'])->name('settings.masters.jabatan.struktural.edit');
                    Route::post('data', [SettingsMastersJabatanStruktural::class, 'data'])->name('settings.masters.jabatan.struktural.data');
                });
                Route::prefix('fungsional')->group(function () {
                    Route::get('index', [SettingsMastersJabatanFungsional::class, 'index'])->name('settings.masters.jabatan.fungsional.index');
                    Route::post('store', [SettingsMastersJabatanFungsional::class, 'store'])->name('settings.masters.jabatan.fungsional.store');
                    Route::delete('delete', [SettingsMastersJabatanFungsional::class, 'delete'])->name('settings.masters.jabatan.fungsional.delete');
                    Route::patch('edit', [SettingsMastersJabatanFungsional::class, 'edit'])->name('settings.masters.jabatan.fungsional.edit');
                    Route::post('data', [SettingsMastersJabatanFungsional::class, 'data'])->name('settings.masters.jabatan.fungsional.data');
                });
            });
        });
    });
    Route::get('/su', function () {
        event(new JoinConnection());
    });
});
