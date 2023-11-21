<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// dashboard
Breadcrumbs::for('dashboard.index', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});

// settings
Breadcrumbs::for('settings.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.index');
    $trail->push('Settings');
});

// settings > role
Breadcrumbs::for('settings.role.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Role', route('settings.role.index'));
});

// settings > permission
Breadcrumbs::for('settings.permission.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Permission', route('settings.permission.index'));
});

// settings > menu
Breadcrumbs::for('settings.menu.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Menu', route('settings.menu.index'));
});

// settings > user
Breadcrumbs::for('settings.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('User', route('settings.user.index'));
});

// settings > logo
Breadcrumbs::for('settings.logo.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Logo', route('settings.logo.index'));
});

// settings > masters
Breadcrumbs::for('settings.masters.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.index');
    $trail->push('Masters');
});

// settings > masters > jabatan
Breadcrumbs::for('settings.masters.jabatan.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Jabatan');
});

// settings > masters > jabatan > struktural
Breadcrumbs::for('settings.masters.jabatan.struktural.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.jabatan.index');
    $trail->push('Struktural', route('settings.masters.jabatan.struktural.index'));
});

// settings > masters > sub-unit
Breadcrumbs::for('settings.masters.sub-unit.index', function (BreadcrumbTrail $trail) {
    $trail->parent('settings.masters.index');
    $trail->push('Sub unit', route('settings.masters.sub-unit.index'));
});
