<?php

use App\Events\JoinConnection;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Jstree\Menu\JstreeMenu;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
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

Route::get('logout', [Logout::class, 'logout']);

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
    });
    Route::get('/su', function () {
        event(new JoinConnection());
    });
});
